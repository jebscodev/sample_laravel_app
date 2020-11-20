<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Equity;
use App\Http\Resources\Equity as EquityResource;
use App\Http\Requests\StoreEquity;
use App\EquityBreakdown;

class EquityController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $equity = Equity::with([
            'client'
        ]);

        if ($request->has('project')) {
            $project_id = $request->query('project');
            $result = $equity->whereHas('client', function($query) use ($project_id) {
                return $query->where('project_id', $project_id);
            })
            ->paginate();
        } else {
            $result = $equity->paginate();
        }

        return EquityResource::collection($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEquity $request)
    {
        $payload = $request->all();

        // save parent model
        $equity = new Equity($payload);
        $equity->equity_paid_pctg = $this->getPercentage($equity->total_equity_paid, $equity->total_equity);
        $equity->created_by = $this->loggedInUser()->id;
        $equity->updated_by = $this->loggedInUser()->id;
        $equity->save();

        // save related model
        if (isset($payload['reservation_date'])) {
            $equity->equities_breakdown()->saveMany($this->generateBreakdown($payload));
        }

        return new EquityResource(Equity::findOrFail($equity->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new EquityResource(
            Equity::with([
                'client:id,client_name'
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
        $payload = $request->all();
        $equity = Equity::findOrFail($id);
        
        foreach ($payload as $field => $value) {
            $equity->$field = $value;
        }

        $equity->equity_paid_pctg = $this->getPercentage($equity->total_equity_paid, $equity->total_equity);
        $equity->updated_by = $this->loggedInUser()->id;
        $equity->updated_date = $this->getCurDate();
        $equity->save();

        return new EquityResource(Equity::findOrFail($equity->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $equity = Equity::findOrFail($id);
        $equity->delete();

        return $this->sendResponse([
            "message" => "Record deleted succesfully."
        ]);
    }

    private function generateBreakdown($payload) 
    {
        $breakdowns = [];
        $reservation_date = $this->formatDate($payload['reservation_date']);
        $due_date = $this->formatDate($reservation_date. ' + 30 days');

        for ($i = 1; $i <= $payload['months_to_pay']; $i++) {
            $breakdown_payload = [
                'equity_no' => $i,
                'due_date' => $due_date,
                'monthly_equity' => $payload['monthly_equity']
            ];

            $breakdown = new EquityBreakdown($breakdown_payload);
            $breakdown->created_by = $this->loggedInUser()->id;
            $breakdown->updated_by = $this->loggedInUser()->id;
            $breakdowns[] = $breakdown;

            $due_date = $this->formatDate($breakdown_payload['due_date']. ' + 30 days');
        }

        return $breakdowns;
    }
}
