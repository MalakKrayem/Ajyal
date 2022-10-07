<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $courses = Course::filter($request->query());
        // ->with('group:id,title')
        // ->paginate();

        //  return CourseResource::collection($courses);

        return CourseResource::collection(Course::all());

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(CourseRequest::rules());
        $data = $request->except("image");
        if ($request->hasFile("image")) {
        $file = $request->file("image"); //return uploadedfile object
        $path = $file->store("uploads", "public");
        $data["image_path"] = $path;
    }
        $course=new Course();
        $course->title = $request->input("title");
        $course->description = $request->input("description");
        $course->budget = $request->input("budget");
        $course->hour_count = $request->input("hour_count");
        $course->participants_count = $request->input("participants_count");
        $course->start_date = $request->input("start_date");
        $course->end_date = $request->input("end_date");
        $course->status = $request->input("status");
        $course->mentor_id = $request->input("mentor_id");
        $course->group_id = $request->input("group_id");
        if(isset($data["image_path"])){
            $course->image=$data["image_path"];
        }
        $course->save();
        if($course){
            return $this->apiResponse($course,"The course saved!",201);
        }
        return $this->apiResponse(null,"The course not saved!",404);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        return new CourseResource($course);

        return $course
            ->load('group:id,title','mentor:id,first_name');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Course $course)
    {
        if(!$course){
            return $this->apiResponse(null,'Not found!',500);
        }
        $request->validate(CourseRequest::rules());
        $data = $request->except("image");
        if ($request->hasFile("image")) {
            $file = $request->file("image"); //return uploadedfile object
            $path = $file->store("uploads", "public");
            $data["image_path"] = $path;
        }

        if(isset($data["image_path"])){
            $course->image_path = $data["image_path"];
        }
        $course->update($request->all());

        if($course){
            return $this->apiResponse(new CourseResource($course),'Course update succeccfully!',Response::HTTP_OK);

        }
            return $this->apiResponse(null,"The Course not updated!",404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        if($course){
            $course->delete();
            return $this->apiResponse(null,"The course deleted sucessfuly!",200);
        }else{
            return 'not found';
        }
        // $user = Auth::guard('sanctum')->user();
        // if (!$user->tokenCan('courses.delete')) {
        //     return response([
        //         'message' => 'Not allowed'
        //     ], 403);
        // }

        // course::destroy($id);
        // return [
        //     'message' => 'course deleted successfully',
        // ];
    }
}
