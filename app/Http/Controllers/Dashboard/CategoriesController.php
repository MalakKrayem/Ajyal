<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class CategoriesController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $categories = Category::filter($request->query())
        ->orderBy('categories.title')
        ->paginate();

        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    $request->validate(CategoryRequest::rules());
    $data = $request->except("image");
    if ($request->hasFile("image")) {
        $file = $request->file("image"); //return uploadedfile object
        $path = $file->store("uploads", "public");
        $data["image_path"] = $path;
    }
        $category=new Category();
        $category->title=$request->input('title');
        $category->description=$request->input('description');
        if(isset($data["image_path"])){
            $category->image=$data["image_path"];
        }
        $category->save();
        if($category){
            return $this->apiResponse($category,"The category saved!",201);
        }
        return $this->apiResponse(null,"The category not saved!",404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {

        if($category){
            return $this->apiResponse(new CategoryResource($category),"Ok",200);
        }
        return $this->apiResponse(null,"Not Found!",404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request , Category $category)
    {
        if(!$category){
            return $this->apiResponse(null,'Not found!',500);
        }
        $request->validate(CategoryRequest::rules());
        $data = $request->except("image");
        if ($request->hasFile("image")) {
            $file = $request->file("image"); //return uploadedfile object
            $path = $file->store("uploads", "public");
            $data["image_path"] = $path;
        }
        if(isset($data["image_path"])){
            $category->image=$data["image_path"];
        }
        $category->update($request->all());

        if($category){
            return $this->apiResponse(new CategoryResource($category),'Category update succeccfully!',Response::HTTP_OK);
        }
        return $this->apiResponse(null,'Error',500);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {

        if(!$category){
            return $this->apiResponse(null,"Not Found!",Response::HTTP_NOT_FOUND);
        }
        // if($category->image) {
        //     Storage::disk("public")->delete($category->image);
        // }
        $category->delete();
        return $this->apiResponse(new CategoryResource($category),"The category deleted sucessfuly!",Response::HTTP_OK);

    //     $user = Auth::guard('sanctum')->user();
    //     if (!$user->tokenCan('category.delete')) {
    //         return response([
    //             'message' => 'Not allowed'
    //         ], 403);
    //     }

    //     Category::destroy($id);
    //     return [
    //         'message' => 'Category deleted successfully',
    //     ];
     }
}
