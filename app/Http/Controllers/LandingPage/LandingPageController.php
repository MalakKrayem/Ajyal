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
        return $this->apiResponse([
            'pageContent'=>$landingPage,
            'advertisings'=>$advertisings,
            'partners'=>$partners,
            'traning_statistic'=>$traning_statistic,
            'members'=>$members,
            'activites'=>$activites,
            'groups'=>$groups
        ],'Done',200);
    }

    public function store(LandingPageRequest $request)
    {

        $landingPage = LandingPage::updateOrCreate(['key' => $request->key], $request->all());
        $landingPage->save();
        return $this->apiResponse(new LandingPageResource($landingPage), 'Done', 201);
    }
}
