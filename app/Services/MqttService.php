<?php

namespace App\Services;

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Console\Output\OutputInterface; 
use App\Events\Publish;

use App\Console\Commands\SubscribeToMqtt;

use App\Utilities;
use App\Helpers;

class MqttService
{
    private $output;

    private $client;
    private $topics = [
        // 'eerc_disco_street-transformer_newHaven_assemblies',
        // 'egbings/pv',
        // 'ihovborts/tv', 'ihovborts/status',
        // 'jebbaTs/tv', 'jebbaTs/status',
        // 'kainjits/tv', 'kainjits/status',
        // 'odukpanits/pv', 'odukpanits/status',
        // 'OkpaiippGs/tv', 'OkpaiippGs/status',
        'omokugs/pv',
        // 'phmains/tv', 'phmains/status', 'parasenergyPs/pv',
        // 'riversIppPs/pr', 'riversIppPs/status',
        // 'sapelets/pv', 'sapelets/status',
        // 'shirorogs/pv', 'transamadi/tv',
        // 'gbaraints/pv', 'gbaraints/status',
        // 'zungeru/tv', 'zungeru/status',
        // 'taopex/tv', 'taopex/status',
        // Add more topics as needed
    ];

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;

        $server   = env('MQTT_HOST');
        $port     = env('MQTT_PORT');
        $clientId = env('MQTT_CLIENT_ID', 'laravel-mqtt-client-' . uniqid());
        $username = env('MQTT_USERNAME');
        $password = env('MQTT_PASSWORD');

        // Utilities::logStuff("username: ".$username);
        // Utilities::logStuff("password: ".$password);

        $connectionSettings = (new ConnectionSettings)
            ->setUsername($username)
            ->setPassword($password)
            ->setKeepAliveInterval(60)
            ->setLastWillTopic('client/disconnected')
            ->setLastWillMessage('Client disconnected')
            ->setLastWillQualityOfService(1)
            ->setLastWillQualityOfService(1)
            ->setLastWillQualityOfService(1);

            // Utilities::logStuff("server: ".$server);
            // Utilities::logStuff("port: ".$port);
            // Utilities::logStuff("clientId: ".$clientId);

        $this->client = new MqttClient($server, $port, $clientId);

        try {
            $this->client->connect($connectionSettings, true);
            Log::info('Connected to MQTT broker');
            Utilities::logStuff('Connected to MQTT broker');
        } catch (\Exception $e) {
            Log::error('Failed to connect to MQTT broker: ' . $e->getMessage());
            Utilities::logStuff('Failed to connect to MQTT broker: ' . $e->getMessage());
        }
    }

    public function subscribe()
    {
        foreach ($this->topics as $topic) {
            $this->client->subscribe($topic, function ($topic, $message) {
                $topic = Helpers::formatTopic($topic);
                $this->handleMessage($topic, $message);
            });
            Log::info("Subscribed to topic: $topic");
            $this->output->writeln("Subscribed to topic: $topic");
            // Utilities::logStuff("Subscribed to topic: $topic");
        }

        try {
            $this->client->loop(true);
        } catch (\Exception $e) {
            Log::error('Error in MQTT loop: ' . $e->getMessage());
            Utilities::logStuff('Error in MQTT loop: ' . $e->getMessage());
            // Implement reconnection logic here
            $this->reconnect();
        }
    }

    private function handleMessage($topic, $message)
    {
        // Log::info("Received message on topic {$topic}: {$message}");
        $this->output->writeln("Received message on topic {$topic}: {$message}");

        // Utilities::logStuff("Received message on topic {$topic}: {$message}");
        
        // Parse the message (assuming it's JSON)
        // try{
        //     // $data = json_decode($message, true);
        //     // $this->output->writeln("Received message on topic {$topic}: {$data}");
        // }catch(\Exception $e) {
        //     $this->output->writeln("Error occured ...".$e);
        // }
        
        if (json_last_error() === JSON_ERROR_NONE) {
            // Broadcast the data using Laravel Reverb
            broadcast(new Publish($topic, $message));
            $this->output->writeln('event published on '.$topic.' Channel');
        } else {
            Log::warning("Received invalid JSON on topic {$topic}");
            Utilities::logStuff("Received invalid JSON on topic {$topic}");
        }
    }

    public function publish($topic, $message)
    {
        try {
            $this->client->publish($topic, json_encode($message), 1);
            Log::info("Published message to topic: $topic");
        } catch (\Exception $e) {
            Log::error("Failed to publish message: " . $e->getMessage());
        }
    }

    private function reconnect()
    {
        Log::info("Attempting to reconnect to MQTT broker");
        Utilities::logStuff("Attempting to reconnect to MQTT broker");
        // Implement exponential backoff or other reconnection strategy
        sleep(1);
        $this->__construct($this->output);
        $this->subscribe();
    }

    public function __destruct()
    {
        if ($this->client->isConnected()) {
            $this->client->disconnect();
        }
    }
}