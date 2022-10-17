<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendenceRequest;
use App\Http\Resources\AttendenceResource;
use App\Models\Attendence;
use App\Models\CourseDay;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AttendenceController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $CourseDay)
    {
        $attendences = AttendenceResource::collection(Attendence::where("course_days_id",$CourseDay)->filter($request->query())->get());
        return $this->apiResponse($attendences,'Done',Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttendenceRequest $request)
    {
        $data=json_decode($request->getContent(), true);

        $courseDay=new CourseDay();
        $courseDay->course_id=$data['course_id'];
        $courseDay->date=$data['date'];
        $courseDay->save();

        foreach($data['students'] as $id=>$status){
            $attendence=new Attendence();
            $attendence->course_days_id=$courseDay->id;
            $attendence->student_id=$id;
            $attendence->status=$status;
            $attendence->save();
        }
        return $this->apiResponse($attendence,'Saved',Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendence  $attendence
     * @return \Illuminate\Http\Response
     */
    public function show(Attendence $attendence)
    {
        return $this->apiResponse($attendence,'Done',Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendence  $attendence
     * @return \Illuminate\Http\Response
     */
    public function update(AttendenceRequest $request, Attendence $attendence)
    {
        $data=json_decode($request->getContent(), true);

        $courseDay=CourseDay::find($attendence->course_days_id);
        $courseDay->course_id=$data['course_id'];
        $courseDay->date=$data['date'];
        $courseDay->save();

        foreach($data['students'] as $id=>$status){
            $attendence->course_days_id=$courseDay->id;
            $attendence->student_id=$id;
            $attendence->status=$status;
            $attendence->save();
        }

        return $this->apiResponse($attendence,'Updated!',Response::HTTP_CREATED);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendence  $attendence
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendence $attendence)
    {
        $attendence->delete();
        return $this->apiResponse(null,'Deleted',Response::HTTP_OK);
    }
}
