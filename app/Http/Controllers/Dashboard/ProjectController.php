<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\ProjectPartnerEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\ProjectPartner;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    use ApiResponseTrait;
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        
        $projects = Project::filter($request->query())
        ->orderBy('projects.title')->paginate(2);


        $has_more_page=$projects->hasMorePages();
        $data['has_more_page'] = $has_more_page;
        
        $projectsr=ProjectResource::collection($projects);
        $data['projectsr']=$projectsr;
        
        if($projects->isEmpty()){
            return $this->apiResponse(null, 'No projects found', 404);
        }
        return $this->apiResponse($data,'Done',200);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        $data = $request->except("image");
        if ($request->hasFile("image")) {
            $file = $request->file("image");
            $path = $file->store("uploads", "public");
            $data["image_path"] = $path;
        }

        $project = new Project();
        $project->title = $request->input("title");
        $project->description = $request->input("description");
        $project->budget = $request->input("budget");
        $project->status = $request->input("status");
        $project->start_date = $request->input("start_date");
        $project->end_date = $request->input("end_date");
        if(isset($data["image_path"])){
            $project->image = $data["image_path"];
        }
        $project->save();

        foreach ($request->partner_id as $partner) {
            // $data = [];
            $data['project_id'] = $project->id;
            $data['partner_id'] = $partner;

            $projectPartner = ProjectPartner::create($data);
        }

    //   event(new ProjectPartnerEvent($project->id,$request->input("partner_id")));

        if($project){
            return $this->apiResponse(new ProjectResource($project),"The project saved!",201);
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
    public function update(ProjectRequest $request, Project $project)
    {
        $data = $request->except(['image']);
        if ($request->hasFile("image")) {
            $file = $request->file("image");
            $path = $file->store("uploads", "public");
            $data["image_path"] = $path;
        }

        if(isset($data["image_path"])){

            $project->image = $data["image_path"];
        }
        
        $project->save($data);
        
        //To add new many partner
        if ($request->partner_id) {
            foreach ($request->partner_id as $partner) {
                 $data = [];
                $data['project_id'] = $project->id;
                $data['partner_id'] = $partner;

                $projectPartner = ProjectPartner::create($data);
            }
        }

        //To delete partner
        // if ($request->deleted_partner) {
        //     foreach (ProjectPartner::where('project_id', $project->id)->whereIn('partner_id', $request->deleted_partner)->get() as $partner) {
        //         $partner->delete();
        //     }
        // } 
        
        if($project){
            return $this->apiResponse(new ProjectResource($project),"The project saved!",201);
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
        $project->delete();
        return $this->apiResponse($project,"The project deleted sucessfuly!",200);

    }


    
}