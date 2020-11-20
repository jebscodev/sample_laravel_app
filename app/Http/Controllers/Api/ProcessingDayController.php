<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\StoreProcessingDay;
use Illuminate\Http\Request;
use App\ProcessingDay;
use App\Http\Resources\ProcessingDay as ProcessingDayResource;

class ProcessingDayController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProcessingDayResource::collection(ProcessingDay::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProcessingDay $request)
    {
        $payload = $request->json()->all();
        $processing = new ProcessingDay($payload);
        $processing->created_by = $this->loggedInUser()->id;
        $processing->updated_by = $this->loggedInUser()->id;
        $processing->save();
        return new ProcessingDayResource(ProcessingDay::findOrFail($processing->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ProcessingDay::with('projects')->findOrFail($id);
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
        $processing = ProcessingDay::findOrFail($id);
        
        foreach ($payload as $field => $value) {
            $processing->$field = $value;
        }

        $processing->updated_by = $this->loggedInUser()->id;
        $processing->updated_date = $this->getCurDate();

        $processing->save();
        return new ProcessingDayResource(ProcessingDay::findOrFail($processing->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $processing = ProcessingDay::findOrFail($id);
        // $processing->projects()->detach();
        $processing->delete();
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
        // $days = ProcessingDay::whereIn('id', $request->ids)->get();
        // foreach ($days as $day) {
        //     $day->projects()->detach();
        // }
        
        ProcessingDay::whereIn('id', $request->ids)->delete();
        
        return $this->sendResponse([
            "message" => "Records are deleted successfully."
        ]);
    }
}
