<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Dashboard\ApiResponseTrait;
use App\Models\Student;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    use ApiResponseTrait;


    public function index()
    {      $student=auth()->user();
            $notifications = Notification::where('notifiable_id' , $student->id)->orderBy('created_at');
    // {      $student=auth()->user()->unreadNotifications;
            return $this->apiResponse($notifications,"Done",200);


    }

    public function read(Request $request)
    {
        $student=auth()->user();
        $noti = $student->unreadNotifications->where('id' , $request->id)->firstOrFail();

        $noti->read_at = Carbon::now();
        $noti->save();
        return $this->apiResponse($noti,"Done",200);




    }


    public function readAll(Request $request)
    {
        $student=auth()->user();
        $noti = $student->unreadNotifications->update(['read_at' => Carbon::now()]);
        return $this->apiResponse($noti,"Done",200);

    }

    public function delete(Request $request)
    {
        $student=auth()->user();
        $student->unreadNotifications->whereId($request->id)->delete();
        return $this->apiResponse(null,"notification delete",200);

    }
}

