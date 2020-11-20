<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests\StoreEquityPercentage;
use App\EquityPercentage;
use App\Http\Resources\EquityPercentage as EquityPercentageResource;

class EquityPercentageController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return EquityPercentageResource::collection(EquityPercentage::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEquityPercentage $request)
    {
        $payload = $request->json()->all();
        $equity = new EquityPercentage($payload);
        $equity->created_by = $this->loggedInUser()->id;
        $equity->updated_by = $this->loggedInUser()->id;
        $equity->save();
        return new EquityPercentageResource(EquityPercentage::findOrFail($equity->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return EquityPercentage::findOrFail($id);
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
        $equity = EquityPercentage::findOrFail($id);

        foreach ($payload as $field => $value) {
            $equity->$field = $value;
        }

        $equity->save();
        return new EquityPercentageResource(EquityPercentage::findOrFail($equity->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $equity = EquityPercentage::findOrFail($id);
        $equity->delete();
        return $this->sendResponse([
            "message" => "Record deleted successfully."
        ]);
    }
}
