<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\LoanTakeout;
use App\Http\Resources\LoanTakeout as LoanTakeoutResource;
use App\Http\Requests\StoreLoanTakeout;

class LoanTakeoutController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $loan = LoanTakeout::with([
            'client'
        ]);

        if ($request->has('project')) {
            $project_id = $request->query('project');
            $result = $loan->whereHas('client', function($query) use ($project_id) {
                $query->where('project_id', $project_id);
            })
            ->paginate();
        } else {
            $result = $loan->paginate();
        }

        return LoanTakeoutResource::collection($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLoanTakeout $request)
    {
        $payload = $request->all();
        $loan = new LoanTakeout($payload);
        $loan->created_by = $this->loggedInUser()->id;
        $loan->updated_by = $this->loggedInUser()->id;
        $loan->save();

        return new LoanTakeoutResource(LoanTakeout::findOrFail($loan->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new LoanTakeoutResource(LoanTakeout::findOrFail($id));
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
        $loan = LoanTakeout::findOrFail($id);

        foreach ($payload as $field => $value) {
            $loan->$field = $value;
        }

        $loan->updated_by = $this->loggedInUser()->id;
        $loan->updated_date = $this->getCurDate();
        $loan->save();

        return new LoanTakeoutResource(LoanTakeout::findOrFail($loan->id)); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $loan = LoanTakeout::findOrFail($id);
        $loan->delete();

        return $this->sendResponse([
            "message" => "Record deleted successfully."
        ]);
    }
}
