<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\StoreOtherCharge;
use Illuminate\Http\Request;
use App\OtherCharge;
use App\Http\Resources\OtherCharge as OtherChargeResource;

class OtherChargeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return OtherChargeResource::collection(OtherCharge::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOtherCharge $request)
    {
        $payload = $request->json()->all();
        $charge = new OtherCharge($payload);
        $charge->created_by = $this->loggedInUser()->id;
        $charge->updated_by = $this->loggedInUser()->id;
        $charge->save();
        return new OtherChargeResource(OtherCharge::findOrFail($charge->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return OtherCharge::with('projects')->findOrFail($id);
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
        $charge = OtherCharge::findOrFail($id);
        
        foreach ($payload as $field => $value) {
            $charge->$field = $value;
        }

        $charge->updated_by = $this->loggedInUser()->id;
        $charge->updated_date = $this->getCurDate();

        $charge->save();
        return new OtherChargeResource(OtherCharge::findOrFail($charge->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $charge = OtherCharge::findOrFail($id);
        // $charge->projects()->detach();
        $charge->delete();
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
        // $charges = OtherCharge::whereIn('id', $request->ids)->get();
        // foreach ($charges as $charge) {
        //     $charge->projects()->detach();
        // }
        
        OtherCharge::whereIn('id', $request->ids)->delete();
        
        return $this->sendResponse([
            "message" => "Records are deleted successfully."
        ]);
    }
}
