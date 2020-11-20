<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\EquityBreakdown;
use App\Http\Resources\EquityBreakdown as EquityBreakdownResource;
use App\Http\Requests\StoreEquityBreakdown;

class EquityBreakdownController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $equity = EquityBreakdown::with([
            'equity_payment:id,receipt_no_equity,receipt_no_penalty,date_paid'
        ]);

        if ($request->has('equity')) {
            $equity_id = $request->query('equity');
            $result = $equity->where('equity_id', $equity_id)
                ->paginate()
                ->appends(['equity' => $equity_id]);
        } else {
            $result = $equity->paginate();
        }

        return EquityBreakdownResource::collection($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEquityBreakdown $request)
    {
        $payload = $request->all();
        $breakdown = new EquityBreakdown($payload);
        $breakdown->due_date = $this->formatDate($breakdown->due_date);
        $breakdown->created_by = $this->loggedInUser()->id;
        $breakdown->updated_by = $this->loggedInUser()->id;
        $breakdown->save();

        return new EquityBreakdownResource(EquityBreakdown::findOrFail($breakdown->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new EquityBreakdownResource(EquityBreakdown::findOrFail($id));
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
        $breakdown = EquityBreakdown::findOrFail($id);

        foreach ($payload as $field => $value) {
            $breakdown->$field = $value;
        }

        $breakdown->due_date = $this->formatDate($breakdown->due_date);
        $breakdown->updated_by = $this->loggedInUser()->id;
        $breakdown->updated_date = $this->getCurDate();

        return new EquityBreakdownResource(EquityBreakdown::findOrFail($breakdown->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $breakdown = EquityBreakdown::findOrFail($id);
        $breakdown->delete();

        return $this->sendResponse([
            "message" => "Record deleted succesfully."
        ]);
    }
}
