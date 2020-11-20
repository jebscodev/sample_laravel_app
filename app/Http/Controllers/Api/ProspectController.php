<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProspect;
use App\Prospect;
use App\Http\Resources\Prospect as ProspectResource;
use App\Http\Resources\ProspectList as ProspectListResource;

class ProspectController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProspectListResource::collection(Prospect::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProspect $request)
    {
        $payload = $request->json()->all();
        $prospect = new Prospect($payload);

        $prospect->created_by = $this->loggedInUser()->id;
        $prospect->updated_by = $this->loggedInUser()->id;

        $prospect->save();
        return new ProspectResource(Prospect::findOrFail($prospect->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Prospect::findOrFail($id);
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
        $prospect = Prospect::findOrFail($id);

        foreach ($payload as $field => $value) {
            $prospect->$field = $value;
        }

        $prospect->updated_by = $this->loggedInUser()->id;
        $prospect->updated_date = $this->getCurDate();

        $prospect->save();
        return new ProspectResource(Prospect::findOrFail($prospect->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $prospect = Prospect::findOrFail($id);
        $prospect->delete();

        return $this->sendResponse([
            "message" => "Record deleted succesfully."
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
        Prospect::whereIn('id', $request->ids)->delete();   
        return $this->sendResponse([
            "message" => "Records are deleted successfully."
        ]);
    }
}
