<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Client;
use App\Document;
use App\Http\Resources\Document as DocumentResource;
use App\Http\Resources\DocumentList as DocumentListResource;

class DocumentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $documents = Document::with([
            'client:id,client_name,project_id,unit_id',
            'client.project:id,name',
            'client.unit:id,unit_no'
        ]);

        if ($request->has('project')) {
            $project_id = $request->query('project');

            return DocumentListResource::collection(
                $documents->whereHas('client', function ($query) use ($project_id) {
                $query->where('project_id', $project_id);
                })
                ->paginate()
            );

        } else {
            return DocumentListResource::collection($documents->paginate());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $payload = $request->all();
        $submission = new Document($payload);

        $submission->created_by = $this->loggedInUser()->id;
        $submission->updated_by = $this->loggedInUser()->id;

        $submission->save();
        return new DocumentResource(Document::findOrFail($submission->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new DocumentResource(Document::with([
            'client:id,client_name,project_id,unit_id',
            'client.project:id,name',
            'client.unit:id,unit_no'
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
        $submission = Document::findOrFail($id);
        
        foreach ($payload as $field => $value) {
            $submission->$field = $value;
        }

        $submission->updated_by = $this->loggedInUser()->id;
        $submission->updated_date = $this->getCurDate();
        $submission->save();

        return new DocumentResource(Document::with([
            'client:id,client_name,project_id,unit_id',
            'client.project:id,name',
            'client.unit:id,unit_no'
        ])->findOrFail($submission->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $submission = Document::findOrFail($id);
        $submission->delete();

        return $this->sendResponse([
            "message" => "Record deleted successfully."
        ]);
    }
}
