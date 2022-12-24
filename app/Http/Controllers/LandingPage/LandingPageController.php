<?php

namespace App\Http\Controllers\LandingPage;

use App\Models\User;
use App\Models\Group;
use App\Models\Course;
use App\Models\Partner;
use App\Models\Project;
use App\Models\Student;
use App\Models\Activity;
use App\Models\Question;
use App\Models\Advertising;
use App\Models\LandingPage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\GroupResource;
use App\Http\Resources\ActivityResource;
use App\Http\Requests\LandingPageRequest;
use App\Http\Resources\LandingPageResource;
use App\Http\Resources\GroupLandingResource;
use App\Http\Controllers\Dashboard\ApiResponseTrait;
use App\Http\Resources\ProjectResource;

class LandingPageController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $landingPage = LandingPageResource::collection(LandingPage::all());
        $partners = Partner::all();
        $members = User::all();
        $activites = Activity::all();
        $advertisings = Advertising::all();
        $projects=ProjectResource::collection(Project::all());
        $traning_statistic = GroupLandingResource::collection(Group::all());
        $groups = Group::all();
        $questions = Question::all();
        $students = Student::where('rate', 'Featured')->get();
        $beneficiaries =  Student::count();
        $women = Student::where('gender', 'female')->count();
        $project = Project::count();
        //أنشطة مدنية =>1
        $social_activity = Activity::where('activity_type_id', 1)->count();



        $data['pageContent'] = $landingPage;
        $data['advertisings'] = $advertisings;
        $data['projects']=$projects;
        $data['partners'] = $partners;
        $data['traning_statistic'] = $traning_statistic;
        $data['members'] = $members;


        $activities = Activity::latest()->paginate(8);

        $has_more_page = $activities->hasMorePages();
        $data['has_more_page'] = $has_more_page;

        $current_page = $activities->currentPage();
        $data['current_page'] = $current_page;

        $paginator = $activities->currentPage();

        if ($activities->hasMorePages()) {

            $data['next'] = $paginator + 1;
        }
        if ($current_page > 1) {
            $data['previous'] = $paginator - 1;
        }
        $activitiess = ActivityResource::collection($activities);
        $data['activities'] = $activitiess;




        $groups = Group::paginate(15);


        $has_more_page = $groups->hasMorePages();
        $data['has_more_page_group'] = $has_more_page;

        $current_page = $groups->currentPage();
        $data['current_page_groups'] = $current_page;

        $paginator = $groups->currentPage();

        if ($groups->hasMorePages()) {

            $data['next_groups'] = $paginator + 1;
        }
        if ($current_page > 1) {
            $data['previous_groups'] = $paginator - 1;
        }

        $groups = GroupResource::collection($groups);
        $data['groups'] = $groups;


        $data['questions'] = $questions;
        $data['students'] = $students;
        $data['beneficiaries'] = $beneficiaries;
        $data['women'] = $women;
        $data['project'] = $project;
        $data['social_activity'] = $social_activity;

        return $this->apiResponse($data, 'Done', 200);
    }

    public function store(LandingPageRequest $request,$key)
    {
        $images=[];
        $data=$request->except('images');
        $ourKey=$key;
        if ($request->has('images')){
                foreach ($request->file('images') as $key => $file){
                    // Get FileName
                    $filenameWithExt = $file->getClientOriginalName();
                    //Get just filename
                    $filename = pathinfo( $filenameWithExt, PATHINFO_FILENAME);
                    //Get just extension
                    $extension = $file->getClientOriginalExtension();
                    //Filename to Store
                    $fileNameToStore = $filename.'_'.time().'.'.$extension;
                    //Upload Image
                    $path = $file->store('uploads','public');
                    array_push($images, $path);
                }
        }
        $data=['content'=>$request->content , 'images' => $images];
        $landingPage = LandingPage::updateOrCreate(['key' => $ourKey], [
            'value' => json_encode($data),
        ]);

        $landingPage->save();
        return $this->apiResponse($landingPage,'Done',201);
    }


}