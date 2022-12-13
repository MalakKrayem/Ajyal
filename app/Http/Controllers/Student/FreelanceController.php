<?php

namespace App\Http\Controllers\Student;

use App\Events\AchievementAdded;
use App\Events\DeleteFreelanceJob;
use App\Events\UpdatePlatformJobsCount;
use App\Events\UpdateStudentIncome;
use App\Events\UpdateStudentJobs;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\ApiResponseTrait;
use App\Http\Requests\FreelanceRequest;
use App\Http\Resources\FreelanceResource;
use App\Listeners\AddAchievement;
use App\Models\Freelance;
use App\Models\Student;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FreelanceController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $freelances = FreelanceResource::collection(Freelance::filter(request()->all())->get());
        if($freelances->isEmpty()){
            return $this->apiResponse(null, 'No Freelances Found', Response::HTTP_NOT_FOUND);
        }
        return $this->apiResponse($freelances,'Done',Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FreelanceRequest $request)
    {
        $data = $request->except("attachment");
        if ($request->hasFile("attachment")) {
            $file = $request->file("attachment"); //return uploadedfile object
            $path = $file->store("uploads", "public");
            $data["attachment_path"] = $path;
        }

        $freelance=new Freelance();

        $freelance->platform_id=$request->input('platform_id');
        $freelance->student_id=$request->input('student_id');
        $freelance->group_id=$request->input('group_id');
        $freelance->job_title=$request->input('job_title');
        $freelance->job_description=$request->input('job_description');
        $freelance->job_link=$request->input('job_link');
        $freelance->salary=$request->input('salary');
        $freelance->client_feedback=$request->input('client_feedback');
        $freelance->status=$request->input('status');
        $freelance->notes=$request->input('notes');
        if(isset($data["attachment_path"])){
            $freelance->attachment = $data["attachment_path"];
        }

        $freelance->save();

        event(new UpdateStudentJobs($request->input('student_id'),1));
        event(new UpdateStudentIncome($request->input('salary'),$request->input('student_id'),null));
        event(new UpdatePlatformJobsCount($request->input('platform_id'),1));
        event(new AchievementAdded($freelance));
        return $this->apiResponse(new FreelanceResource($freelance),'Done',Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Freelance  $freelance
     * @return \Illuminate\Http\Response
     */
    public function show(Freelance $freelance)
    {
        return $this->apiResponse(new FreelanceResource($freelance),'Done',Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Freelance  $freelance
     * @return \Illuminate\Http\Response
     */
    public function update(FreelanceRequest $request, Freelance $freelance)
    {

        $old_salary=$freelance->salary;
        $new_salary=$request->input('salary');
        if ($request->hasFile("attachment")) {
            $file = $request->file("attachment"); //return uploadedfile object
            $path = $file->store("uploads", "public");
            $data["attachment_path"] = $path;
        }

        $freelance->platform_id=$request->input('platform_id');
        $freelance->student_id=$request->input('student_id');
        $freelance->group_id=$request->input('group_id');
        $freelance->job_title=$request->input('job_title');
        $freelance->job_description=$request->input('job_description');
        $freelance->job_link=$request->input('job_link');
        if(isset($data["attachment_path"])){
            $freelance->attachment = $data["attachment_path"];
        }
        $freelance->salary=$request->input('salary');
        $freelance->client_feedback=$request->input('client_feedback');
        $freelance->status=$request->input('status');
        $freelance->notes=$request->input('notes');

        $freelance->save();


        event(new UpdateStudentIncome($new_salary,$request->input('student_id'),$old_salary));

        return $this->apiResponse(new FreelanceResource($freelance),'Done',Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Freelance  $freelance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Freelance $freelance)
    {
        $freelance->delete();
        event(new DeleteFreelanceJob($freelance));
        return $this->apiResponse(null,'Done',Response::HTTP_OK);
    }

    public function showGroups(Request $request){
        $request->validate(['student_id'=>'required|integer|exists:students,id']);
        $student=Student::find($request->student_id);
        $groups=$student->groups;
        return $groups;
    }
}