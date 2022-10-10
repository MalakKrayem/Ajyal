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
    public function index(CategoryRequest $request)
    {
        $categories = Category::filter($request->query())
        ->orderBy('categories.title')
        ->paginate();

        return $this->apiResponse(CategoryResource::collection($categories), 'Done', 200);
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

        $category = Category::create($request->all());
        if($category){
        return $this->apiResponse(new CategoryResource($category),'Category Saved!',200);

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

        return $this->apiResponse(new CategoryResource($category),"Ok",200);

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
            return $this->apiResponse($category,"The category saved!",201);
        }
        return $this->apiResponse(null,"The category not saved!",404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if($category){
            $category->delete();
            return $this->apiResponse(null,"The category deleted sucessfuly!",200);
        }else{
            return 'not found';
        }
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
