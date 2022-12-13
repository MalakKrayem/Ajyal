<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\Student;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\ApiResponseTrait;



class NotificationController extends Controller
{
    use ApiResponseTrait;


    public function index()
    {

        $mentor = auth()->user();
        $notifications = Notification::where($mentor)->get();


        // {      $student=auth()->user()->unreadNotifications;
        return $this->apiResponse($notifications, "Done", 200);
    }

    // public function read(Request $request)
    // {
    //     $student=auth()->user();
    //     $noti = $student->unreadNotifications->where('id' , $request->id)->firstOrFail();

    //     $noti->read_at = Carbon::now();
    //     $noti->save();
    //     return $this->apiResponse($noti,"Done",200);




    // }


    // public function readAll(Request $request)
    // {
    //     $student=auth()->user();
    //     $noti = $student->unreadNotifications->update(['read_at' => Carbon::now()]);
    //     return $this->apiResponse($noti,"Done",200);

    // }

    // public function delete(Request $request)
    // {
    //     $student=auth()->user();
    //     $student->unreadNotifications->whereId($request->id)->delete();
    //     return $this->apiResponse(null,"notification delete",200);

    // }
}