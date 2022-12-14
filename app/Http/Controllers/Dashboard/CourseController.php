<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CourseController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $groups = Course::all();
        return $this->apiResponse(CourseResource::collection($groups),'Done',200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRequest $request)
    {
        $data = $request->except("image");
        if ($request->hasFile("image")) {
            $file = $request->file("image"); //return uploadedfile object
            $path = $file->store("uploads", "public");
            $data["image_path"] = $path;
        }

        $course = new Course();
        $course->title = $request->input("title");
        $course->description = $request->input("description");
        $course->hour_count = $request->input("hour_count");
        $course->start_date = $request->input("start_date");
        $course->end_date = $request->input("end_date");
        $course->status = $request->input("status");
        $course->mentor_id = $request->input("mentor_id");
        $course->group_id = $request->input("group_id");
        if(isset($data["image_path"])){
            $course->image = $data["image_path"];
        }
        $course->save();
        if($course){
            return $this->apiResponse(new CourseResource($course),"The Course saved!",201);
        }
            return $this->apiResponse(null,"The Course not saved!",404);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        return $this->apiResponse(new CourseResource($course),'Done',200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourseRequest $request, Course $course)
    {
        $data = $request->except("image");
        if ($request->hasFile("image")) {
            $file = $request->file("image");
            $path = $file->store("uploads", "public");
            $data["image_path"] = $path;
        }
        $course=new Course();
        $course->title = $request->input("title");
        $course->description = $request->input("description");
        $course->hour_count = $request->input("hour_count");
        $course->start_date = $request->input("start_date");
        $course->end_date = $request->input("end_date");
        $course->status = $request->input("status");
        $course->mentor_id = $request->input("mentor_id");
        $course->group_id = $request->input("group_id");
        if(isset($data["image_path"])){
            $course->image = $data["image_path"];
        }

        
        $course->save();
        
        if($course){
            return $this->apiResponse(new CourseResource($course),"The Course saved!",201);
        }
            return $this->apiResponse(null,"The Course not saved!",404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return $this->apiResponse(new CourseResource($course),"The course deleted sucessfuly!",200);
    }
}