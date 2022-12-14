<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Student;
use App\Events\StudentAdded;
use App\Models\StudentGroup;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Events\StudentGroupEvent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StudentRequest;
use App\Http\Resources\StudentResource;
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
        $students=StudentResource::collection(Student::get());
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
    public function store(StudentRequest $request)
    {
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
        $student->gender=$request->input('gender');
        if(isset($data["image_path"])){
            $student->image=$data["image_path"];
        }
        $student->save();

        foreach ($request->group_id as $group) {
            // $data = [];
            $data['student_id']=$student->id;
            $data['group_id'] = $group;

            $studentGroup = StudentGroup::create($data);
            // event(new StudentAdded($studentGroup, $group_id));
        }

        // event(new StudentGroupEvent($student->id,$request->input("group_id")));
        if ($student) {
            return $this->apiResponse(new StudentResource($student), "The project saved!", 201);
        }
        return $this->apiResponse(null, "The Student not saved!", 404);    }

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
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'required',
                Rule::unique('students', 'email')->ignore($student->id)
            ],
            'phone' => [
                'required',
                Rule::unique('students', 'phone')->ignore($student->id)
            ],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg',
            'address' => 'required|string|max:255',
            'rate' => 'string|in:Featured,Junior,Average,Unclassified',
            'transport' => 'integer|min:0',
            'status' => 'required|in:active,inactive',
            'total_income' => 'numeric|min:0',
            'total_jobs' => 'integer|min:0',
            'gender'=>'required|string|in:female,male',
            // 'group_id'=>'required|exists:groups,id',
            'deleted_student'=>'array',
        ]);
        $data = $request->except(['image','group_id']);
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
        $student->rate=$request->input("rate");
        $student->status=$request->input("status");
        $student->phone=$request->input("phone");
        $student->transport=$request->input('transport');
        $student->gender=$request->input('gender');
        if(isset($data["image_path"])){
            $student->image=$data["image_path"];
        }
        $student->update();
        
        //to delete student from StudentGroup
        //    if ($request->deleted_student) {
        //     foreach (StudentGroup::where('student_id',$student->id)->whereIn('group_id',$request->deleted_student)->get()as $stu) {
        //        $stu->delete();
        //     }
        // } 
        
        //To add student into group
        if($request->group_id){
            foreach ($request->group_id as $group) {
                $data = [];
                $data['student_id'] = $student->id;
                $data['group_id'] = $group;

                $studentGroup = StudentGroup::updateOrCreate($data);
            }
        }
        
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