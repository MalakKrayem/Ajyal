<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\ApiResponseTrait;
use App\Models\Mentor;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class AccessTokenController extends Controller
{
    use ApiResponseTrait;
    // To create token
    public function store(Request $request,$guard){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|max:15',
            'device_name' => 'string|max:255'
        ]);

        if($guard == 'admin'){
            $user= User::where('email',$request->input('email'))->first();
        }
        if($guard == 'mentor'){
            $user= Mentor::where('email',$request->input('email'))->first();
        }
        if($guard == 'student'){
            $user= Student::where('email',$request->input('email'))->first();
        }
        if($user){
            if(Hash::check($request->input('password'),$user->password)){
                $device_name = $request->post('device_name', $request->userAgent());
                $token=$user->createToken($device_name)->plainTextToken;
                return $this->apiResponse(['token'=>$token, 'user'=>$user],"Ok",200);
            }
        }
        // Credentials are incorrect
        return $this->apiResponse(null,"Credentials are incorrect",401);
    }

    // To delete token
    public function destroy($token = null){
        $user=Auth::guard('sanctum')->user();

        if(null === $token){
            $user->currentAccessToken()->delete();
            return $this->apiResponse(null,"Logout successfully!",Response::HTTP_CREATED);
        }

        $personalAccessToken=PersonalAccessToken::findToken($token);
        if($user->id == $personalAccessToken->tokenable_id && get_class($user) == $personalAccessToken->tokenable_type){
            $personalAccessToken->delete();
            return $this->apiResponse($user,"Logout successfully!",Response::HTTP_OK);
        }

        return $this->apiResponse(null,"Unauthorized!",Response::HTTP_UNAUTHORIZED);
    }

    //update password
    public function updatePassword(Request $request)
{
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        #Match The Old Password
        if(!Hash::check($request->old_password, auth()->user()->password)){
            return $this->apiResponse(null,"Old Password Doesn't match!");
        }

        $authModel=get_class(auth()->user());
        $authClass = class_basename($authModel);
        if($authClass == 'User'){
            User::whereId(auth()->user()->id)->update([
                'password' => Hash::make($request->new_password)
            ]);

            return $this->apiResponse(null,"Password changed successfully!",200);
        }
        if($authClass == 'Mentor'){
            Mentor::whereId(auth()->user()->id)->update([
                'password' => Hash::make($request->new_password)
            ]);

            return $this->apiResponse(null,"Password changed successfully!",200);
        }
        if($authClass == 'Student'){
            Student::whereId(auth()->user()->id)->update([
                'password' => Hash::make($request->new_password)
            ]);

            return $this->apiResponse(null,"Password changed successfully!",404);
        }

}

}