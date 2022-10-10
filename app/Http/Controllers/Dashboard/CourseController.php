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

        // $groups = Course::all();
        // return $this->apiResponse(CourseResource::collection($groups),'Done',200);

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
        $course = Course::create($request->all());
        if($course){
           return $this->apiResponse(new CourseResource($course),'course Saved!',200);

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

        return $course
            ->load('group:id,title','mentor:id,first_name');
        return $this->apiResponse(new CourseResource($course),'Done',200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Course $course)
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
            $course->image = $data["image_path"];
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
        $course->delete();
        return $this->apiResponse(new CourseResource($course),"The course deleted sucessfuly!",200);
    }
}
