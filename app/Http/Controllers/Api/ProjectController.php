<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\StoreProject;
use Illuminate\Http\Request;
use App\Project;
use App\Http\Resources\Project as ProjectResource;
use App\Http\Resources\ProjectList as ProjectListResource;

class ProjectController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProjectListResource::collection(Project::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProject $request)
    {
        $payload = $request->json()->all();

        // insert parent model first
        $project = new Project($payload);
        $project->created_by = $this->loggedInUser()->id;
        $project->updated_by = $this->loggedInUser()->id;
        $project->save();

        // attach related pivot data if any
        $related_models = ['unit_types', 'processing_days', 'other_charges'];
        $pivot = [];

        foreach ($related_models as $model) {
            if (isset($payload[$model]) && !empty($payload[$model])) {
                $pivot[$model] = $payload[$model];
            }
        }

        if (!empty($pivot)) {
            $project->attachPivot($pivot);
        }

        return new ProjectResource(
            Project::with([
                'unit_types',
                'processing_days',
                'other_charges'
            ])
            ->findOrFail($project->id)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new ProjectResource(
            Project::with([
                'unsold_units:id,unit_no,project_id',
                'unit_types',
                'processing_days',
                'other_charges'])
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
        $payload = $request->json()->all();
        $project = Project::findOrFail($id);

        // update related pivot data if any
        $related_models = ['unit_types', 'processing_days', 'other_charges'];
        $pivot = [];

        foreach ($related_models as $model) {
            if (isset($payload[$model])) {
                $pivot[$model] = $payload[$model];
                unset($payload[$model]);
            }
        }

        if (!empty($pivot)) {
            $project->updatePivot($pivot);
        }

        // update parent model
        foreach ($payload as $field => $value) {
            $project->$field = $value;
        }

        $project->updated_by = $this->loggedInUser()->id;
        $project->updated_date = $this->getCurDate();
        $project->save();

        return new ProjectResource(
            Project::with([
                'unit_types',
                'processing_days',
                'other_charges'
            ])
            ->findOrFail($project->id)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        // $project->unit_types()->detach();
        // $project->processing_days()->detach();
        // $project->other_charges()->detach();
        // $project->units()->delete();
        // $project->clients()->delete();
        $project->delete();

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
        $projects = Project::whereIn('id', $request->ids)->get();
        foreach ($projects as $project) {
            // $project->unit_types()->detach();
            // $project->processing_days()->detach();
            // $project->other_charges()->detach();
            // $project->units()->delete();
            // $project->clients()->delete();
        }
        
        Project::whereIn('id', $request->ids)->delete();
        
        return $this->sendResponse([
            "message" => "Records are deleted successfully."
        ]);
    }
}
