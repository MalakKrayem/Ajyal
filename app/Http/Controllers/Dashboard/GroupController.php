<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupRequest;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use PHPUnit\Framework\MockObject\Api;

class GroupController extends Controller
{
    use ApiResponseTrait;

    // / * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    public function index(Request $request)
    {

        // $groups = Group::filter($request->query())
        // ->with('project:id,title','category:id,title')
        // ->paginate();

        //  return GroupResource::collection($groups);

         return GroupResource::collection(Group::all());



    }

    public function store(Request $request)
    {
        $request->validate(GroupRequest::rules());
        $data = $request->except("image");
        if ($request->hasFile("image")) {
        $file = $request->file("image"); //return uploadedfile object
        $path = $file->store("uploads", "public");
        $data["image_path"] = $path;
    }
        $group = new Group();
        $group->title = $request->input("title");
        $group->description = $request->input("description");
        $group->budget = $request->input("budget");
        $group->hour_count = $request->input("hour_count");
        $group->participants_count = $request->input("participants_count");
        $group->status = $request->input("status");
        $group->start_date = $request->input("start_date");
        $group->end_date = $request->input("end_date");
        $group->category_id = $request->input("category_id");
        $group->project_id = $request->input("project_id");
        if(isset($data["image_path"])){
            $group->image = $data["image_path"];
        }
        $group->save();
        if($group){
            return $this->apiResponse($group,"The group saved!",201);
        }
            return $this->apiResponse(null,"The group not saved!",404);
        }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        return $this->apiResponse($group, 'Done', 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        if(!$group){
            return $this->apiResponse(null,'Not found!',500);
        }
        $request->validate(GroupRequest::rules());
        $data = $request->except("image");
        if ($request->hasFile("image")) {
            $file = $request->file("image"); //return uploadedfile object
            $path = $file->store("uploads", "public");
            $data["image_path"] = $path;
        }

        if(isset($data["image_path"])){
            $group->image = $data["image_path"];
        }
        $group->update($request->all());

        if($group){
            return $this->apiResponse(new GroupResource($group),'Group update succeccfully!',Response::HTTP_OK);

        }
            return $this->apiResponse(null,"The Group not updated!",404);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->delete();
        return $this->apiResponse($group,"The group deleted sucessfuly!",200);
    }
}
