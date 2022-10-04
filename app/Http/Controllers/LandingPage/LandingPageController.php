<?php

namespace App\Http\Controllers\LandingPage;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\ApiResponseTrait;
use App\Http\Requests\LandingPageRequest;
use App\Http\Resources\LandingPageResource;
use App\Models\Activity;
use App\Models\Advertising;
use App\Models\Group;
use App\Models\LandingPage;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    use ApiResponseTrait;

    public function index(){
        $landingPage = LandingPageResource::collection(LandingPage::all());
        $advertisings=Advertising::published()->get();
        $partners=Partner::all();
        $groups=Group::all();
        $members=User::all();
        $activites=Activity::all();
        return $this->apiResponse([
            'pageContent'=>$landingPage,
            'advertisings'=>$advertisings,
            'partners'=>$partners,
            'groups'=>$groups,
            'members'=>$members,
            'activites'=>$activites
        ],'Done',200);
    }

    public function store(Request $request)
    {
        $request->validate(LandingPageRequest::rules());
        //edit
        $section = LandingPage::where('key', $request->key)->first();
        if($section){
            $section->update($request->all());
            return $this->apiResponse(new LandingPageResource($section),'Done',200);
        }
        $landingPage = LandingPage::updateOrCreate($request->all());
        $landingPage->save();
        return $this->apiResponse(new LandingPageResource($landingPage), 'Done', 201);
    }
}
