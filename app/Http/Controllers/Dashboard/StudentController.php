<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students=StudentResource::collection(Student::paginate(10));
        if($students->isEmpty()){
            return $this->apiResponse(null,'No Students Found',Response::HTTP_NOT_FOUND);
        }
        return $this->apiResponse($students,'All Students',Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(StudentRequest::rules());
        $data = $request->except("image");
        if ($request->hasFile("image")) {
            $file = $request->file("image"); //return uploadedfile object
            $path = $file->store("uploads", "public");
            $data["image_path"] = $path;
        }
        $student = new Student();
        $student->first_name = $request->input("first_name");
        $student->last_name = $request->input("last_name");
        $student->email= $request->input("email");
        $student->password=Hash::make($request->input("password"));
        $student->address=$request->input("address");
        $student->status=$request->input("status");
        $student->phone=$request->input("phone");
        $student->transport=$request->input('transport');
        if(isset($data["image_path"])){
            $student->image=$data["image_path"];
        }
        $student->save();
        return $this->apiResponse(new StudentResource($student),'Student Created Successfully',Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        return $this->apiResponse(new StudentResource($student),'Done',Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $request->validate(StudentRequest::rules());
        $data = $request->except("image");
        if ($request->hasFile("image")) {
            $file = $request->file("image"); //return uploadedfile object
            $path = $file->store("uploads", "public");
            $data["image_path"] = $path;
        }
        $student->first_name = $request->input("first_name");
        $student->last_name = $request->input("last_name");
        $student->email= $request->input("email");
        $student->password=Hash::make($request->input("password"));
        $student->address=$request->input("address");
        $student->status=$request->input("status");
        $student->phone=$request->input("phone");
        $student->transport=$request->input('transport');
        if(isset($data["image_path"])){
            $student->image=$data["image_path"];
        }
        $student->save();
        return $this->apiResponse(new StudentResource($student),'Student Updated Successfully',Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $student->delete();
        if($student->image){
            Storage::disk('public')->delete($student->image);
        }
        return $this->apiResponse(null,'Student Deleted Successfully',Response::HTTP_NO_CONTENT);
    }
}
