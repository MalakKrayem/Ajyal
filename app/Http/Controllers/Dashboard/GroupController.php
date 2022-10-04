<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupRequest;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\MockObject\Api;

class GroupController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $groups = GroupResource::collection(Group::all());
        // $groups = Group::filter($request->query())
        //         ->with('category:id,title', 'project:id,title')
        //         ->paginate();
        //     //  dd($groups) ;
        return GroupResource::collection($groups);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator=Validator($request->all(),GroupRequest::rules());
        $data = $request->except("image");
        if ($request->hasFile("image")) {
            $file = $request->file("image");
            $path = $file->store("uploads", "public");
            $data["image_path"] = $path;
        }
        if($validator->fails()){
            return $this->apiResponse(null,$validator->errors(),400);
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
            $group->image_path = $data["image_path"];
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
        return new GroupResource($group);

        return $group
            ->load('category:id,title', 'project:id,title');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $validator=Validator($request->all(),GroupRequest::rules());
        $data = $request->except("image");
        if ($request->hasFile("image")) {
            $file = $request->file("image");
            $path = $file->store("uploads", "public");
            $data["image_path"] = $path;
        }
        if($validator->fails()){
            return $this->apiResponse(null,$validator->errors(),400);
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
            $group->image_path = $data["image_path"];
        }
        $group->update();
        if($group){
            return $this->apiResponse($group,"The group updated!",201);
        }
            return $this->apiResponse(null,"The group not updated!",404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {

        if($group){
            $group->delete();
            return $this->apiResponse(null,"The group deleted sucessfuly!",200);
        }else{
            return 'not found';
        }
        // $user = Auth::guard('sanctum')->user();
        // if (!$user->tokenCan('groups.delete')) {
        //     return response([
        //         'message' => 'Not allowed'
        //     ], 403);
        // }

        // Group::destroy($id);
        // return [
        //     'message' => 'Group deleted successfully',
        // ];
    }
}
