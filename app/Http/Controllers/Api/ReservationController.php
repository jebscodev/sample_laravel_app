<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\StoreReservation;
use Illuminate\Http\Request;
use App\Client;
use App\Http\Resources\Client as ClientResource;
use App\Http\Resources\ClientList as ClientListResource;
use App\Document;

class ReservationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ClientListResource::collection(
            Client::with('documents:id,client_id,requirements_status,date_completed')
            ->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReservation $request)
    {
        $payload = $request->all();
        
        // extract related model data
        if (isset($payload['documents'])) {
            $documents = new Document($payload['documents']);
            $documents->created_by = $this->loggedInUser()->id;
            $documents->updated_by = $this->loggedInUser()->id;

            // set completed date for completed docs
            if ($documents->requirements_status == 1) {
                $documents->date_completed = $this->getCurDate();
            }

            unset($payload['documents']);
        }
        
        // save parent model
        $client = new Client($payload);
        $client->reservation_date = date("Y-m-d", strtotime($client->reservation_date));
        $client->created_by = $this->loggedInUser()->id;
        $client->updated_by = $this->loggedInUser()->id;
        $client->save();

        // save related model
        if (isset($documents)) {
            $client->documents()->save($documents);
        }

        // update selected unit to 'sold'
        $client->unit()->update([
            'sale_status' => 1
        ]);

        return new ClientResource(Client::with([
            'documents',
            'project:id,name',
            'unit:id,unit_no',
            'prospect:id,first_name,last_name',
            'broker:id,first_name,last_name'
        ])->findOrFail($client->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new ClientResource(Client::with([
            'documents',
            'project:id,name',
            'unit',
            'prospect:id,first_name,last_name',
            'broker:id,first_name,last_name'
        ])->findOrFail($id));
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
        $client = Client::findOrFail($id);
        
        // update related model
        if (isset($payload['documents'])) {
            $payload['documents']['updated_by'] = $this->loggedInUser()->id;
            $payload['documents']['updated_date'] = $this->getCurDate();

            if ($payload['documents']['requirements_status'] == 1) {
                $payload['documents']['date_completed'] = $this->getCurDate();
            } else {
                $payload['documents']['date_completed'] = null;
            }

            $client->documents()->update($payload['documents']);
            unset($payload['documents']);
        }
        
        // update parent model
        $payload['reservation_date'] = date("Y-m-d", strtotime($payload['reservation_date']));
        $client->fill($payload);
        $client->updated_by = $this->loggedInUser()->id;
        $client->updated_date = $this->getCurDate();
        $client->save();

        return new ClientResource(Client::with([
            'documents',
            'project:id,name',
            'unit',
            'prospect:id,first_name,last_name',
            'broker:id,first_name,last_name'
        ])->findOrFail($client->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

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
        Client::whereIn('id', $request->ids)->delete();
        
        return $this->sendResponse([
            "message" => "Records are deleted successfully."
        ]);
    }
}
