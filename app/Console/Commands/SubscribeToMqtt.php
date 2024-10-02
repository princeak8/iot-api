<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Output\OutputInterface; 
use App\Services\MqttService;

class SubscribeToMqtt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mqtt:subscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscribe to MQTT topics and broadcast messages';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $output = $this->output;
        $mqttService = new MqttService($output);
        $this->info('Subscribing to MQTT topics...');
        $mqttService->subscribe();
    }
}
