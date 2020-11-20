<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Ewt;
use App\Http\Resources\Ewt as EwtResource;
use App\Http\Requests\StoreEwt;

class EwtController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return EwtResource::collection(
            Ewt::with([
                'client:id,client_name'
            ])
            ->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEwt $request)
    {
        $payload = $request->all();
        $ewt = new Ewt($payload);
        $ewt->rcp_date = $this->formatDate($ewt->rcp_date);
        $ewt->est_release_date = $this->formatDate($ewt->est_release_date);
        $ewt->actual_release_date = $this->formatDate($ewt->actual_release_date);
        $ewt->date_paid = $this->formatDate($ewt->date_paid);
        $ewt->created_by = $this->loggedInUser()->id;
        $ewt->updated_by = $this->loggedInUser()->id;
        $ewt->save();

        return new EwtResource(Ewt::findOrFail($ewt->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new EwtResource(Ewt::findOrFail($id));
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
        $ewt = Ewt::findOrFail($id);

        foreach ($payload as $field => $value) {
            $ewt->$field = $value;
        }

        $ewt->rcp_date = $this->formatDate($ewt->rcp_date);
        $ewt->est_release_date = $this->formatDate($ewt->est_release_date);
        $ewt->actual_release_date = $this->formatDate($ewt->actual_release_date);
        $ewt->date_paid = $this->formatDate($ewt->date_paid);
        $ewt->updated_by = $this->loggedInUser()->id;
        $ewt->updated_date = $this->getCurDate();
        $ewt->save();
        
        return new EwtResource(Ewt::findOrFail($ewt->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ewt = Ewt::findOrFail($id);
        $ewt->delete();

        return $this->sendResponse([
            "message" => "Record deleted successfully."
        ]);
    }
}
