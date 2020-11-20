<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\StoreUnit;
use Illuminate\Http\Request;
use App\Unit;
use App\Http\Resources\Unit as UnitResource;
use App\Http\Resources\UnitList as UnitListResource;

class UnitController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('count') && $request->has('value')) {
            $field = $request->query('count');
            $value = $request->query('value');

            if($request->has('project')){
                $project_id = $request->query('project');
                $count = Unit::where($field, $value)
                    ->where('project_id', $project_id)
                    ->count();
            }else{
                $count = Unit::where($field, $value)->count();
            }
            return $this->sendResponse(['count' => $count]);

        } else if ($request->has('project')) {
            $project_id = $request->query('project');
            $units = Unit::with([
                'client:unit_id,id,client_name'
            ]);
            
            if ($request->has('filter') && $request->has('value')) {
                $filter_fld = $request->query('filter');
                $filter_val = $request->query('value');

                $result = $units->where($filter_fld, $filter_val)
                    ->where('project_id', $project_id)
                    ->paginate();

            } else {
                $result = $units->where('project_id', $project_id)
                    ->paginate();
            }

            return UnitListResource::collection($result);

        } else {
            return UnitListResource::collection(Unit::paginate());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUnit $request)
    {
        $payload = $request->json()->all();
        $unit = new Unit($payload);
        $unit->created_by = $this->loggedInUser()->id;
        $unit->updated_by = $this->loggedInUser()->id;
        $unit->save();
        return new UnitResource(
            Unit::with([
                'project:id,name', 
                'unit_type:id,name'
            ])
            ->findOrFail($unit->id)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new UnitResource(
            Unit::with([
                'project:id,name', 
                'unit_type:id,name'
            ])
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
        $unit = Unit::findOrFail($id);
        
        foreach ($payload as $field => $value) {
            $unit->$field = $value;
        }

        $unit->save();

        return new UnitResource(
            Unit::with([
                'project:id,name', 
                'unit_type:id,name'
            ])
            ->findOrFail($unit->id)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);
        $unit->delete();
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
        Unit::whereIn('id', $request->ids)->delete();   
        return $this->sendResponse([
            "message" => "Records are deleted successfully."
        ]);
    }
}
