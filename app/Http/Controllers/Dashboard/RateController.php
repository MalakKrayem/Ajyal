<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\UpdateStudentRate;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\ApiResponseTrait;
use App\Http\Requests\RateRequest;
use App\Http\Resources\RateResource;
use App\Models\Rate;
use Illuminate\Http\Request;

class RateController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rates = RateResource::collection(Rate::all());
        if($rates->isEmpty()){
            return $this->apiResponse(null, 'No rates found', 404);
        }
        return $this->apiResponse($rates,'Done',200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RateRequest $request)
    {
        $rate = Rate::create($request->all());

        event(new UpdateStudentRate($rate->student_id,null,null));

        return $this->apiResponse(new RateResource($rate),'Rate Saved!',200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function show(Rate $rate)
    {
        return $this->apiResponse(new RateResource($rate),'Done',200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function update(RateRequest $request, Rate $rate)
    {
        $old_rate=$rate->rate;
        $new_rate=$request->input('rate');

        $rate->update($request->all());

        event(new UpdateStudentRate($rate->student_id,$old_rate,$new_rate));

        return $this->apiResponse(new RateResource($rate),'Rate Updated!',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rate $rate)
    {
        $rate->delete();
        event(new UpdateStudentRate($rate->student_id,null,null));
        return $this->apiResponse(new RateResource($rate),'Rate Deleted!',200);
    }
}
