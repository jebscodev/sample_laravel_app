<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\StoreModule;
use Illuminate\Http\Request;
use App\Http\Resources\Module as ModuleResource;
use App\RoleModuleTagging;
use App\Module;

class ModuleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ModuleResource::collection(Module::isModule()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreModule $request)
    {
        $payload = $request->json()->all();
        $module = new Module($payload);
        
        $module->created_by = $this->loggedInUser()->id;
        $module->updated_by = $this->loggedInUser()->id;

        $module->save();
        return new ModuleResource(Module::findOrFail($module->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Module::findOrFail($id);
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
        $module = Module::findOrFail($id);

        $module->updated_by = $this->loggedInUser()->id;
        $module->updated_date = $this->getCurDate();

        foreach ($payload as $field => $value) {
            $module->$field = $value;
        }

        $module->save();
        return new ModuleResource(Module::findOrFail($module->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $module = Module::findOrFail($id);

        // delete tagging first
        $tag = new RoleModuleTagging;
        $tag->where('module_id', $module->id)->delete();

        // then delete module
        $module->delete();

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
        RoleModuleTagging::whereIn('module_id', $request->ids)->delete();  
        Module::whereIn('id', $request->ids)->delete();

        return $this->sendResponse([
            "message" => "Records are deleted successfully."
        ]);
    }
}
