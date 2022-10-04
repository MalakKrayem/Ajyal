<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\ApiResponseTrait;
use App\Models\Mentor;
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
        }else if($guard == 'mentor'){
            $user= Mentor::where('email',$request->input('email'))->first();
        }
        if($user){
            if(Hash::check($request->input('password'),$user->password)){
                $device_name = $request->post('device_name', $request->userAgent());
                $token=$user->createToken($device_name)->plainTextToken;
                return $this->apiResponse(['token'=>$token, 'user'=>$user],"Ok",200);
            }
        }
        // Credentials are incorrect
        return $this->apiResponse(null,"Credentials are incorrect",404);
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
}
