<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActivityRequest;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ActivityController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activities = ActivityResource::collection(Activity::all());
        if($activities->isEmpty()){
            return $this->apiResponse(null,'No Activities Found',Response::HTTP_NOT_FOUND);
        }
        return $this->apiResponse($activities,'Done',Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(ActivityRequest::rules());
        $data = $request->except("image");
        if ($request->hasFile("image")) {
            $file = $request->file("image"); //return uploadedfile object
            $path = $file->store("uploads", "public");
            $data["image_path"] = $path;
        }
        $activite=new Activity();
        $activite->title=$request->input('title');
        $activite->description=$request->input('description');
        $activite->date=$request->input('date');
        $activite->project_id=$request->input('project_id');
        $activite->activite_type_id=$request->input('activite_type_id');
        if(isset($data["image_path"])){
            $activite->image = $data["image_path"];
        }
        $activite->save();
        return $this->apiResponse(new ActivityResource($activite),'Activity Created!',Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activity  $activite
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activite)
    {
        return $this->apiResponse(new ActivityResource($activite),'Done',Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Activity  $activite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activity $activite)
    {
        $request->validate(ActivityRequest::rules());
        $data = $request->except("image");
        if ($request->hasFile("image")) {
            $file = $request->file("image"); //return uploadedfile object
            $path = $file->store("uploads", "public");
            $data["image_path"] = $path;
        }
        $activite->title=$request->input('title');
        $activite->description=$request->input('description');
        $activite->date=$request->input('date');
        $activite->project_id=$request->input('project_id');
        $activite->activity_type_id=$request->input('activite_type_id');
        if(isset($data["image_path"])){
            $activite->image = $data["image_path"];
        }
        $activite->save();
        return $this->apiResponse(new ActivityResource($activite),'Activity Updated!',Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Activity  $activite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activite)
    {
        $activite->delete();
        if($activite->image){
            Storage::disk('public')->delete($activite->image);
        }
        return $this->apiResponse(null,'Activity Deleted!',Response::HTTP_NO_CONTENT);
    }
}