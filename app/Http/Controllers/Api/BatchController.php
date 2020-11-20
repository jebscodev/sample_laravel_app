<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\User;
use App\Http\Resources\User as UserResource;
use App\Broker;
use App\Http\Resources\Broker as BrokerResource;
use App\Module;
use App\Http\Resources\Module as ModuleResource;
use App\Role;
use App\Http\Resources\Role as RoleResource;
use App\Project;
use App\Http\Resources\Project as ProjectResource;
use App\Prospect;
use App\Http\Resources\Prospect as ProspectResource;
use App\UnitType;
use App\Http\Resources\UnitType as UnitTypeResource;
use App\Unit;
use App\Http\Resources\Unit as UnitResource;
use App\Client;
use App\Http\Resources\Client as ClientResource;

class BatchController extends BaseController
{
    /**
     * Update single column by batch.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $module
     * @param  string $field
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $module, $field)
    {
        switch ($module) {
            case 'users':
                return UserResource::collection($this->batchUpdate(new User, $field, $request->$field, $request->ids));
                break;
            case 'brokers':
                return BrokerResource::collection($this->batchUpdate(new Broker, $field, $request->$field, $request->ids));
                break;
            case 'modules':
                return ModuleResource::collection($this->batchUpdate(new Module, $field, $request->$field, $request->ids));
                break;
            case 'roles':
                return RoleResource::collection($this->batchUpdate(new Role, $field, $request->$field, $request->ids));
                break;
            case 'projects':
                return ProjectResource::collection($this->batchUpdate(new Project, $field, $request->$field, $request->ids));
                break;
            case 'prospects':
                return ProspectResource::collection($this->batchUpdate(new Prospect, $field, $request->$field, $request->ids));
                break;
            case 'unittypes':
                return UnitTypeResource::collection($this->batchUpdate(new UnitType, $field, $request->$field, $request->ids));
                break;
            case 'units':
                return UnitResource::collection($this->batchUpdate(new Unit, $field, $request->$field, $request->ids));
                break;
            case 'reservations':
                return ClientResource::collection($this->batchUpdate(new Client, $field, $request->$field, $request->ids));
                break;
            default:
                return $this->sendError([
                    "message" => "Module not found."
                ]);
                break;
        }
    }
}
