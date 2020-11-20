<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\StoreRoleModuleTagging as StoreTagging;
use Illuminate\Http\Request;
use App\Http\Resources\RoleModuleTagging as TaggingResource;
use App\RoleModuleTagging as Tagging;

class RoleModuleTaggingController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TaggingResource::collection(Tagging::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTagging $request)
    {
        $payload = $request->json()->all();
        $tag = new Tagging($payload);
        $tag->save();
        return new TaggingResource(Tagging::findOrFail($tag->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Tagging::findOrFail($id);
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
        $tag = Tagging::findOrFail($id);
        $tag->updated_date = $this->getCurDate();

        foreach ($payload as $field => $value) {
            $tag->$field = $value;
        }

        $tag->save();
        return new TaggingResource(Tagging::findOrFail($tag->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tagging::findOrFail($id);
        $tag->delete();

        return $this->sendResponse([
            "message" => "Record deleted successfully."
        ]);
    }
}
