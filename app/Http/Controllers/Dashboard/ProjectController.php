<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $projects = Project::filter($request->query())
        ->orderBy('projects.title')
        ->paginate();

        return ProjectResource::collection($projects);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator=Validator($request->all(),ProjectRequest::rules());
        $data = $request->except("image");
        if ($request->hasFile("image")) {
            $file = $request->file("image");
            $path = $file->store("uploads", "public");
            $data["image_path"] = $path;
        }
        if($validator->fails()){
            return $this->apiResponse(null,$validator->errors(),400);
        }
        $project = new Project();
        $project->title = $request->input("title");
        $project->description = $request->input("description");
        $project->budget = $request->input("budget");
        $project->status = $request->input("status");
        $project->start_date = $request->input("start_date");
        $project->end_date = $request->input("end_date");
        if(isset($data["image_path"])){
            $project->image_path = $data["image_path"];
        }
        $project->save();
        if($project){
            return $this->apiResponse($project,"The project saved!",201);
        }
            return $this->apiResponse(null,"The project not saved!",404);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        if($project){
            return $this->apiResponse(new ProjectResource($project),"Ok",200);
        }
        return $this->apiResponse(null,"Not Found!",404);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $validator=Validator($request->all(),ProjectRequest::rules());
        $data = $request->except("image");
        if ($request->hasFile("image")) {
            $file = $request->file("image");
            $path = $file->store("uploads", "public");
            $data["image_path"] = $path;
        }
        if($validator->fails()){
            return $this->apiResponse(null,$validator->errors(),400);
        }
        $project->title = $request->input("title");
        $project->description = $request->input("description");
        $project->budget = $request->input("budget");
        $project->start_date = $request->input("start_date");
        $project->end_date = $request->input("end_date");
        $project->status = $request->input("status");
        if(isset($data["image_path"])){
            $project->image_path = $data["image_path"];
        }
        $project->save();
        if($project){
            return $this->apiResponse($project,"The project saved!",201);
        }
            return $this->apiResponse(null,"The project not saved!",404);
        }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        if($project){
            $project->delete();
            return $this->apiResponse(null,"The project deleted sucessfuly!",200);
        }else{
            return 'not found';
        }
    }
}
