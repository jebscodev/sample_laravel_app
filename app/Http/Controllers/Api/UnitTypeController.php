<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\UnitType;
use App\Project;
use App\Http\Resources\UnitType as UnitTypeResource;
use App\Http\Resources\UnitTypeList as UnitTypeListResource;
use App\Http\Requests\StoreUnitType;

class UnitTypeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('project')) {
            $project_id = $request->query('project');
            return UnitTypeListResource::collection(
                Project::find($project_id)
                ->unit_types()
                ->paginate()
            );

        } else {
            return UnitTypeListResource::collection(UnitType::paginate());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUnitType $request)
    {
        $payload = $request->json()->all();
        $unit_type = new UnitType($payload);
        $unit_type->created_by = $this->loggedInUser()->id;
        $unit_type->updated_by = $this->loggedInUser()->id;
        $unit_type->save();
        return new UnitTypeResource(UnitType::findOrFail($unit_type->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

        if ($request->has('project')) {
            $project_id = $request->query('project');

            return new UnitTypeResource(
                UnitType::with([
                    'projects' => function($query) use ($project_id) {
                        return $query->where('project_id', $project_id);
                    }]
                )
                ->findOrFail($id)
            );
        } else {
            return new UnitTypeResource(UnitType::findOrFail($id));
        }
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
        $unit_type = UnitType::findOrFail($id);
        
        foreach ($payload as $field => $value) {
            $unit_type->$field = $value;
        }

        $unit_type->updated_by = $this->loggedInUser()->id;
        $unit_type->updated_date = $this->getCurDate();

        $unit_type->save();
        return new UnitTypeResource(UnitType::findOrFail($unit_type->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $unit_type = UnitType::findOrFail($id);
        // $unit_type->projects()->detach();
        $unit_type->delete();

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
        // $unit_types = UnitType::whereIn('id', $request->ids)->get();
        // foreach ($unit_types as $unit_type) {
        //     $unit_type->projects()->detach();
        // }
        
        UnitType::whereIn('id', $request->ids)->delete();
        
        return $this->sendResponse([
            "message" => "Records are deleted successfully."
        ]);
    }
}

