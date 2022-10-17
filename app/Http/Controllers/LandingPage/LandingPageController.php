<?php

namespace App\Http\Controllers\LandingPage;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\ApiResponseTrait;
use App\Http\Requests\LandingPageRequest;
use App\Http\Resources\GroupLandingResource;
use App\Http\Resources\LandingPageResource;
use App\Models\Activity;
use App\Models\Advertising;
use App\Models\Group;
use App\Models\LandingPage;
use App\Models\Partner;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    use ApiResponseTrait;

    public function index(){
        $landingPage = LandingPageResource::collection(LandingPage::all());
        $partners=Partner::all();
        $members=User::all();
        $activites=Activity::all();
        $traning_statistic=GroupLandingResource::collection(Group::all());
        $groups=Group::all();
        $questions=Question::all();
        return $this->apiResponse([
            'pageContent'=>$landingPage,
            //'advertisings'=>$advertisings,
            'partners'=>$partners,
            'traning_statistic'=>$traning_statistic,
            'members'=>$members,
            'activites'=>$activites,
            'groups'=>$groups,
            'questions'=>$questions,
        ],'Done',200);
    }

    public function store(LandingPageRequest $request)
    {
        $data=json_decode($request->getContent(), true);
        $images=[];
        foreach ($data as $key=>$value){
            $content=$value['content'];
            foreach ($value['images'] as $image){
                // $file = $image; //return uploadedfile object
                // $path = $file->store("uploads", "public");
                // $data["image_path"] = $path;
                //$images[]=$data["image_path"];
            }
            $data=["content"=>$content,"images"=>$images];
            $landingPage = LandingPage::updateOrCreate(['key' => $key], [
                'value' => $data,
            ]);
            
            $landingPage->save();
        }
        return $this->apiResponse($landingPage, 'Done', 201);
    }
}
