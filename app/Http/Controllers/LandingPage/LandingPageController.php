<?php

namespace App\Http\Controllers\LandingPage;

use App\Models\User;
use App\Models\Group;
use App\Models\Course;
use App\Models\Partner;
use App\Models\Student;
use App\Models\Activity;
use App\Models\Question;
use App\Models\Advertising;
use App\Models\LandingPage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LandingPageRequest;
use App\Http\Resources\LandingPageResource;
use App\Http\Resources\GroupLandingResource;
use App\Http\Controllers\Dashboard\ApiResponseTrait;

class LandingPageController extends Controller
{
    use ApiResponseTrait;

    public function index(){
        $landingPage = LandingPageResource::collection(LandingPage::all());
        $partners=Partner::all();
        $members=User::all();
        $activites=Activity::all();
        $advertisings=Advertising::all();
        $traning_statistic=GroupLandingResource::collection(Group::all());
        $groups=Group::all();
        $questions=Question::all();
        $students=Student::where('rate', 'Featured')->get();
        return $this->apiResponse([
            'pageContent'=>$landingPage,
            'advertisings'=>$advertisings,
            'partners'=>$partners,
            'traning_statistic'=>$traning_statistic,
            'members'=>$members,
            'activites'=>$activites,
            'groups'=>$groups,
            'questions'=>$questions,
            'students'=>$students
        ],'Done',200);

 
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