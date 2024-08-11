<?php

namespace App\Services;

use App\Models\Group;
use App\Models\ComponentGroup;

use App\Services\ComponentService;

class GroupService
{
    public function group($id)
    {
        return Group::find($id);
    }

    public function groups($moduleId)
    {
        return Group::where('module_id', $moduleId);
    }

    public function create($data)
    {
        $group = new Group;
        $group->name = $data['name'];
        $group->moduleId = $data['moduleId'];
        $group->save();
        // Saving group components
        if(isset($data['componentIds'])) {
            $components = [];
            $componentService = new ComponentService;
            foreach($data['componentIds'] as $componentId) $components[] = $componentService->component($componentId);
            $group->components->saveMany($components);
        }
        return $group;
    }

    public function update($group, $data)
    {
        if(isset($data['name'])) $group->name = $data['name'];
        if(isset($data['moduleId'])) $group->moduleId = $data['moduleId'];
        $group->update();
        return $group;
    }

    public function addComponents(Array $componentsId, Number $groupId) 
    {
        foreach($componentsId as $componentId) {
            $componentGroup = new ComponentGroup;
            $componentGroup->group_id = $groupId;
            $componentGroup->component_id = $componentId;
            $componentGroup->save();
        }
    }

    // Detach a component from a group
    public function removeComponents(Array $componentsId, Group $group)
    {
        foreach($group->componentGroups as $componentGroup) {
            if(in_array($componentGroup->componentId, $componentsId)) $componentGroup->delete();
        }
    }


}


?>