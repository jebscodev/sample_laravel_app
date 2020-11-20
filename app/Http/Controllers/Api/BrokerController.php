<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Broker;
use App\Http\Resources\Broker as BrokerResource;
use App\Http\Resources\BrokerList as BrokerListResource;
use App\Http\Requests\StoreBroker;

class BrokerController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BrokerListResource::collection(Broker::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBroker $request)
    {
        $payload = $request->json()->all();
        $broker = new Broker($payload);

        $broker->created_by = $this->loggedInUser()->id;
        $broker->updated_by = $this->loggedInUser()->id;

        $broker->save();
        return new BrokerResource(Broker::findOrFail($broker->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Broker::findOrFail($id);
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
        $broker = Broker::findOrFail($id);
        
        foreach ($payload as $field => $value) {
            $broker->$field = $value;
        }

        $broker->updated_by = $this->loggedInUser()->id;
        $broker->updated_date = $this->getCurDate();

        $broker->save();
        return new BrokerResource(Broker::findOrFail($broker->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $broker = Broker::findOrFail($id);
        // $broker->clients()->delete();
        $broker->delete();

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
        // $brokers = Broker::whereIn('id', $request->ids)->get();
        // foreach ($brokers as $broker) {
        //     $broker->clients()->delete();
        // }
        
        Broker::whereIn('id', $request->ids)->delete();
        
        return $this->sendResponse([
            "message" => "Records are deleted successfully."
        ]);
    }
}
