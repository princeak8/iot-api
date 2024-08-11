<?php

namespace App\Services;

use App\Models\PublishingConfig;

class PublishingConfigService
{
    public function publishingConfig($id)
    {
        return PublishingConfig::find($id);
    }

    public function modulePublishingConfigs($moduleId)
    {
        return PublishingConfig::where('module_id', $moduleId)->get();
    }

    public function save($data)
    {
        $config = new PublishingConfig;
        $config->name = $data['name'];
        $config->json = $data['json'];
        $config->topic = $data['topic'];
        $config->module_id = $data['module_id'];
        $config->save();
        return $config;
    }

    public function createJson($data)
    {
        $json['name'] = $data['module']->name;
        if(isset($data['groups'])) {
            $json['groups'] = [];
            foreach($data['groups'] as $group) {
                $jsonGroup['name'] = $group['group']->name;
                $jsonGroup['components'] = [];
                foreach($group['components'] as $component) {
                    $componentParameters = [];
                    foreach($component->category->parameters as $parameter) $componentParameters[$parameter->unit] = '';
                    $jsonGroup['components'][] = [
                        "name" => $component->name,
                        "identifier" => $component->identifier,
                        "parameters" => $componentParameters
                    ];
                }
                $json['groups'] = $jsonGroup;
            }
        }
        if(isset($data['components'])) {
            $json['components'] = [];
            foreach($data['components'] as $component) {
                $componentParameters = [];
                foreach($component->category->parameters as $parameter) $componentParameters[$parameter->unit] = '';
                $json['components'][] = [
                    "name" => $component->name,
                    "identifier" => $component->identifier,
                    "parameters" => $componentParameters
                ];
            }
        }
        return $json;
    }
}


?>