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
        $advertisings=Advertising::published()->get();
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
        $data = $request->except("image");
        if ($request->hasFile("image")) {
            $file = $request->file("image");
            $path = $file->store("uploads", "public");
            $data["image_path"] = $path;
        }
        // if(isset($data["image_path"])){
        //     $request->image=$data["image_path"];
        // }else{
        //     $request->image='no Image';
        // }

        $landingPage = LandingPage::updateOrCreate(['key' => $request->key], [
            'value' => $request->value,
            'image' => $data["image_path"] ?? 'no Image',
        ]);
        $landingPage->save();
        return $this->apiResponse(new LandingPageResource($landingPage), 'Done', 201);
    }
}
