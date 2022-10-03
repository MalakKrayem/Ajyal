<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\PartnerRequest;
use App\Http\Resources\PartnerResource;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class PartnerController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partners = PartnerResource::collection(Partner::all());
        if ($partners->isEmpty()) {
            return $this->apiResponse(null, 'No partners found', 404);
        }
        return $this->apiResponse($partners,'Done',Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(PartnerRequest::rules());
        $data = $request->except("image");
        if ($request->hasFile("image")) {
            $file = $request->file("image"); //return uploadedfile object
            $path = $file->store("uploads", "public");
            $data["image_path"] = $path;
        }
        $partner= new Partner();
        $partner->name = $request->input("name");
        $partner->description = $request->input("description");
        if(isset($data["image_path"])){
            $partner->logo = $data["image_path"];
        }
        $partner->save();
        if($partner){
            return $this->apiResponse(new PartnerResource($partner),'Partner added successfully!',Response::HTTP_CREATED);
        }
        return $this->apiResponse(null,'Error',Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function show(Partner $partner)
    {
        if($partner){
            return $this->apiResponse(new PartnerResource($partner),'Done',Response::HTTP_OK);
        }
        return $this->apiResponse(null,'Not found!',Response::HTTP_NOT_FOUND);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Partner $partner)
    {
        if(!$partner){
            return $this->apiResponse(null,'Not found!',Response::HTTP_NOT_FOUND);
        }
        $request->validate(PartnerRequest::rules());
        $data = $request->except("image");
        if ($request->hasFile("image")) {
            $file = $request->file("image"); //return uploadedfile object
            $path = $file->store("uploads", "public");
            $data["image_path"] = $path;
        }
        $partner->name = $request->input("name");
        $partner->description = $request->input("description");
        if(isset($data["image_path"])){
            $partner->logo = $data["image_path"];
        }
        $partner->save();
        if($partner){
            return $this->apiResponse(new PartnerResource($partner),'Partner updated successfully!',Response::HTTP_OK);
        }
        return $this->apiResponse(null,'Error',Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Partner $partner)
    {
        if(!$partner){
            return $this->apiResponse(null,"Not Found!",Response::HTTP_NOT_FOUND);
        }

        if($partner->logo) {
            Storage::disk("public")->delete($partner->image);
        }
        $partner->delete();
        return $this->apiResponse(new PartnerResource($partner),"The partner deleted sucessfuly!",Response::HTTP_OK);
    }
}
