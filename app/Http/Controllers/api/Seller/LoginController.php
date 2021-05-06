<?php

namespace App\Http\Controllers\api\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Traits\apiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Validator;

class LoginController extends Controller
{
    use apiResponse;

    public function login(Request $request)
    {
        $user = Seller::where('phone', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $success['token'] =  $user->createToken($user->name)->plainTextToken;
        $success['name'] =  $user->name;
        return $this->successResponse($success,202);
    }

    public function Register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:sellers',
            'phone' =>'required|unique:sellers',
            'password' => 'required|confirmed',
            'latitude' => 'required',
            'longitude' => 'required',
            'online' => 'required|in:0,1'
        ]);

        if($validator->fails()){
            return $this->showMessage( $validator->errors() , 404);
        }

        $data = $request->except('photo');
        if ($request->hasFile('photo'))
        {
            $image  = $request->file('photo');
            $new_name = $data['name'].'.'.$image->getClientOriginalExtension();
            $image->move(public_path("images/users") ,$new_name );
            $data['photo'] = $new_name;
        }
        $data['password'] = bcrypt($data['password']);
        $user = Seller::create($data);
        $success['token'] =  $user->createToken($user->name)->plainTextToken;
        $success['name'] =  $user->name;
        return $this->successResponse($success,202);
    }


    public function logout()
    {
        $user=Auth::guard('seller')->user();
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        return $this->showMessage("you are logout",200);
    }
}
