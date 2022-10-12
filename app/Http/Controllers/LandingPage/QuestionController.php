<?php

namespace App\Http\Controllers\LandingPage;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\ApiResponseTrait;
use App\Http\Requests\QuestionRequest;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions=QuestionResource::collection(Question::all());
        if($questions->isEmpty()){
            return $this->apiResponse(null,'No questions found',404);
        }
        return $this->apiResponse($questions,'All Questions',200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionRequest $request)
    {
        $question=Question::create($request->all());
        return $this->apiResponse(new QuestionResource($question),'Question Created',201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        return $this->apiResponse(new QuestionResource($question),'Question',200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionRequest $request, Question $question)
    {
        $question->update($request->all());
        return $this->apiResponse(new QuestionResource($question),'Question Updated',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return $this->apiResponse(new QuestionResource($question),'Question Deleted',200);
    }
}
