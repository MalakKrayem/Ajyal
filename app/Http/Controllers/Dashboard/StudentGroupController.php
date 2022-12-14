<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\StudentAdded;
use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Student;
use App\Models\StudentGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $availableStudents=Student::whereNotExists(function($query) use ($request){
            $query->select(DB::raw(1))->from('student_group')
            ->where('group_id','=',$request->group_id)
            ->whereColumn('student_id','students.id');
        })->get();
        // $availableStudents=Student::whereDoesntHave('groups',function($query) use ($request){
        //     $query->where('group_id','=',$request->group_id);
        // })->dd();

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
           // 'student_id' => 'required|integer|exists:students,id',
        ]);

        $data =  $request->except('student_id');
        $group_id = StudentGroup::create($data);

        foreach ($request->student as $studentID) {
            // $data = [];
            $data['student_id'] = $studentID;
            
        $studentGroup=StudentGroup::create($data);  
        // event(new StudentAdded($studentGroup, $group_id));
        }

        // $studentGroup=StudentGroup::firstOrCreate([
        //     'group_id' => $request->input('group_id'),
        //     'student_id' => $request->input('student_id'),
        // ]);
        
        // $group_id=$studentGroup->group_id;
        
        // event(new StudentAdded($studentGroup,$group_id));
        return $this->apiResponse($data,'Student added Successfully to the Group',Response::HTTP_CREATED);
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