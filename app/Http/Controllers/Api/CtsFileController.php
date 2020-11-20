<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\CtsFile;
use App\Http\Resources\CtsFile as CtsFileResource;
use App\Http\Requests\StoreCtsFile;

class CtsFileController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CtsFileResource::collection(
            CtsFile::with([
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
    public function store(StoreCtsFile $request)
    {
        $payload = $request->all();
        $cts = new CtsFile($payload);
        $cts->date_printed = $this->formatDate($cts->date_printed);
        $cts->date_signed = $this->formatDate($cts->date_signed);
        $cts->date_notarized = $this->formatDate($cts->date_notarized);
        $cts->created_by = $this->loggedInUser()->id;
        $cts->updated_by = $this->loggedInUser()->id;
        $cts->save();

        return new CtsFileResource(CtsFile::findOrFail($cts->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new CtsFileResource(CtsFile::findOrFail($id));
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
        $cts = CtsFile::findOrFail($id);
        
        foreach ($payload as $field => $value) {
            $cts->$field = $value;
        }

        $cts->date_printed = $this->formatDate($cts->date_printed);
        $cts->date_signed = $this->formatDate($cts->date_signed);
        $cts->date_notarized = $this->formatDate($cts->date_notarized);
        $cts->updated_by = $this->loggedInUser()->id;
        $cts->updated_date = $this->getCurDate();
        $cts->save();

        return new CtsFileResource(CtsFile::findOrFail($cts->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cts = CtsFile::findOrFail($id);
        $cts->delete();

        return $this->sendResponse([
            "message" => "Record deleted successfully."
        ]);
    }
}
