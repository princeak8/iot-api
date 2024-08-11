<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Utilities;

use App\Services\GroupService;
use App\Services\ComponentService;

use App\Http\Requests\PublishingConfig;

class PublishingConfigController extends Controller
{
    private $groupService;
    private $componentService;

    public function __construct()
    {
        $this->groupService = new GroupService;
        $this->componentService = new ComponentService;
    }

    public function save(PublishingConfig $request)
    {
        try{
            $data = $request->all();
            if(isset($data['groups'])) {
                $groups = [];
                foreach($data['groups'] as $group) {
                    $groupObj = $this->groupService->group($group['groupId']);
                    if($groupObj) {
                        if(isset($data['module']) && $groupObj->module_id != $data['module']->id) return Utilities::error402('Every Group must be in the same module');
                        $data['module'] = $groupObj->module;
                        if($groupObj->components->count() > 0) {
                            foreach($group['components'] as $componentId) {
                                $component = $this->componentService->component($componentId);
                                if($component) {
                                    if($component->group_id == $groupObj->id) {
                                        $groups[$groupObj->id]['components'][] = $component;
                                    }else{
                                        return Utilities::error402('component with Id: '.$componentId.' does not belong to group with Id '.$groupObj->id);
                                    }
                                }else{
                                    return Utilities::error402('component with Id: '.$componentId.' does not exist');
                                }
                            }
                            $groups[$groupObj->id]['group'] = $groupObj;
                        }else{
                            return Utilities::error402('components does not exist in the group with groupID: '.$group['groupId']);
                        }
                    }else{
                        return Utilities::error402('groupId '.$group['groupId'].' does not exist');
                    }
                }
                $data['groups'] = $groups;
            }
            if(isset($data['components'])) {
                $components = [];
                $groupIds = (isset($data['groups'])) ? array_keys($groups) : [];
                foreach($data['components'] as $componentId) {
                    $component = $this->componentService->component($componentId);
                    if($component) {
                        if(isset($data['module']) && $component->module_id != $data['module']->id) return Utilities::error402('Every Component must be in the same module');
                        if(!in_array($component->group_id, $groupIds)) {
                            $components[] = $component;
                        }else{
                            return Utilities::error402('component with Id: '.$componentId.' already belong to group with Id '.$component->group_id.' so it cannot exists separately');
                        }
                    }else{
                        return Utilities::error402('component with Id: '.$componentId.' does not exist');
                    }
                }
                $data['components'] = $components;
            }
        }catch(\Exception $e){
            return Utilities::error($e);
        }
    }
}
