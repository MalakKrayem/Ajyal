<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\ApiResponseTrait;
use App\Http\Requests\ActivitesTypeRequest;
use App\Models\ActivitiesType;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ActivitiesTypeController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activitiesTypes = ActivitiesType::all();
        if($activitiesTypes->isEmpty()){
            return $this->apiResponse(null,'No Activities Types Found',Response::HTTP_NOT_FOUND);
        }
        return $this->apiResponse($activitiesTypes,'Done',Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActivitesTypeRequest $request)
    {
        $activitiesType = ActivitiesType::create($request->all());
        return $this->apiResponse($activitiesType,'Type created!',Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ActivitiesType  $activitiesType
     * @return \Illuminate\Http\Response
     */
    public function show(ActivitiesType $activitiesType)
    {
        return $this->apiResponse($activitiesType,'Done',Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ActivitiesType  $activitiesType
     * @return \Illuminate\Http\Response
     */
    public function update(ActivitesTypeRequest $request, ActivitiesType $activitiesType)
    {
        $activitiesType->update($request->all());
        return $this->apiResponse($activitiesType,'Type Updated!',Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ActivitiesType  $activitiesType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ActivitiesType $activitiesType)
    {
        $activitiesType->delete();
        return $this->apiResponse($activitiesType,'Type deleted!',Response::HTTP_NO_CONTENT);
    }
}
