<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\EquityPayment;
use App\Http\Resources\EquityPayment as EquityPaymentResource;
use App\Http\Requests\StoreEquityPayment;

class EquityPaymentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return EquityPaymentResource::collection(EquityPayment::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEquityPayment $request)
    {
        $payload = $request->all();
        $payment = new EquityPayment($payload);
        $payment->date_paid = $this->formatDate($payment->date_paid);
        $payment->created_by = $this->loggedInUser()->id;
        $payment->updated_by = $this->loggedInUser()->id;
        $payment->save();

        return new EquityPaymentResource(EquityPayment::findOrFail($payment->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new EquityPaymentResource(EquityPayment::findOrFail($id));
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
        $payload = $request->all();
        $payment = EquityPayment::findOrFail($id);

        foreach ($payload as $field => $value) {
            $payment->$field = $value;
        }

        $payment->date_paid = $this->formatDate($payment->date_paid);
        $payment->updated_by = $this->loggedInUser()->id;
        $payment->updated_date = $this->getCurDate();
        $payment->save();

        return new EquityPaymentResource(EquityPayment::findOrFail($payment->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = EquityPayment::findOrFail($id);
        $payment->delete();

        return $this->sendResponse([
            "message" => "Record deleted succesfully."
        ]);
    }
}
