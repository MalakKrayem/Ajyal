<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Student;
use App\Models\StudentGroup;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentGroupController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showStudents(Request $request)
    {
        $request->validate([
            'group_id' => 'required|integer|exists:groups,id'
        ]);
        $availableStudents=Student::whereNotIn('id',function($query) use ($request){
            $query->select('student_id')->from('student_group')->where('group_id','!=',$request->group_id);
        })->get();

        // $group = Group::find($request->group_id);
        // $studentsInGroup = $group->students;
        // $students=Student::all();
        // $availableStudents = $students->diff($studentsInGroup);
        return $availableStudents;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate request
        $request->validate([
            'group_id' => 'required|integer|exists:groups,id',
            'student_id' => 'required|integer|exists:students,id',
        ]);

        $studentGroup=StudentGroup::firstOrCreate([
            'group_id' => $request->input('group_id'),
            'student_id' => $request->input('student_id'),
        ]);

        return $this->apiResponse($studentGroup,'Student added Successfully to the Group',Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentGroup  $studentGroup
     * @return \Illuminate\Http\Response
     */
    public function show(StudentGroup $studentGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentGroup  $studentGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentGroup $studentGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentGroup  $studentGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentGroup $studentGroup)
    {
        //
    }
}
