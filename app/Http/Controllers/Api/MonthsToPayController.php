<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMonthsToPay;
use App\MonthsToPay;
use App\Http\Resources\MonthsToPay as MonthsToPayResource;

class MonthsToPayController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return MonthsToPayResource::collection(MonthsToPay::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMonthsToPay $request)
    {
        $payload = $request->json()->all();
        $months = new MonthsToPay($payload);
        $months->created_by = $this->loggedInUser()->id;
        $months->updated_by = $this->loggedInUser()->id;
        $months->save();
        return new MonthsToPayResource(MonthsToPay::findOrFail($months->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return MonthsToPay::findOrFail($id);
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
        $months = MonthsToPay::findOrFail($id);

        foreach ($payload as $field => $value) {
            $months->$field = $value;
        }

        $months->save();
        return new MonthsToPayResource(MonthsToPay::findOrFail($months->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $months = MonthsToPay::findOrFail($id);
        $months->delete();
        return $this->sendResponse([
            "message" => "Record deleted successfully."
        ]);
    }
}
