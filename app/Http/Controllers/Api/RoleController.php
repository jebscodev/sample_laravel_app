<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\StoreRole;
use Illuminate\Http\Request;
use App\Role;
use App\Http\Resources\Role as RoleResource;
use App\Http\Resources\RoleList as RoleListResource;
// use App\Http\Resources\RoleEdit as RoleEditResource;
use App\RoleModuleTagging;

class RoleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('status')) {
            switch (strtolower(trim($request->query('status')))) {
                case 'active':
                    $roles = Role::active()->paginate();
                    break;
                case 'inactive':
                    $roles = Role::inactive()->paginate();
                    break;
            }
        } else {
            $roles = Role::paginate();
        }

        return RoleListResource::collection($roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRole $request)
    {
        $payload = $request->json()->all();
        
        // extract module access from request
        $access = $payload['access'];
        unset($payload['access']);

        // insert role first
        $role = new Role($payload);
        $role->created_by = $this->loggedInUser()->id;
        $role->updated_by = $this->loggedInUser()->id;
        $role->save();

        // then insert tagged modules
        foreach ($access as $tag) {
            $tag['role_id'] = $role->id;
            $module = new RoleModuleTagging($tag);
            $module->save();
        }

        return new RoleResource(Role::findOrFail($role->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new RoleResource(
            Role::with('tagged_modules')
            ->findOrFail($id)
        ); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $payload = $request->json()->all();
        
        // extract module access from request
        if (isset($payload['access'])) {
            $access = $payload['access'];
            unset($payload['access']);
        } else {
            $access = [];
        }

        // update role first
        $role = Role::findOrFail($id);
        foreach ($payload as $field => $value) {
            $role->$field = $value;
        }
        $role->updated_by = $this->loggedInUser()->id;
        $role->updated_date = $this->getCurDate();
        $role->save();

        // then update tagged modules
        foreach ($access as $tag) {
            $module = RoleModuleTagging::where([
                'role_id' => $role->id,
                'module_id' => $tag['module_id']
            ])->first();

            $module->read = $tag['read'];
            $module->write = $tag['write'];
            $module->update = $tag['update'];

            $module->updated_date = $this->getCurDate();
            $module->save();
        }

        return new RoleResource(Role::findOrFail($role->id)); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        // delete tagged modules first
        $module = new RoleModuleTagging;
        $module->where('role_id', $role->id)->delete();

        // then delete role
        $role->delete();
        
        return $this->sendResponse([
            "message" => "Record deleted successfully."
        ]);
    }

    /**
     * Remove a number of resources from storage.
     *
     * @param  array  $ids
     * @return \Illuminate\Http\Response
     */
    public function destroyMany(Request $request) 
    {
        RoleModuleTagging::whereIn('role_id', $request->ids)->delete();   
        Role::whereIn('id', $request->ids)->delete();
        
        return $this->sendResponse([
            "message" => "Records are deleted successfully."
        ]);
    }
}
