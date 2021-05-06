<?php

namespace App\Http\Controllers\api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Validator;

class LoginController extends Controller
{

    public function login(Request $request)
    {

        $user = User::where('phone', $request->phone)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $success['token'] =  $user->createToken($user->name)->plainTextToken;
        $success['name'] =  $user->name;
        return response()->json($success,202);
    }

    public function Register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' =>'required|unique:users',
            'password' => 'required|confirmed',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        if($validator->fails()){
            return response()->json( $validator->errors() , 404);
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
        $user = User::create($data);
        $success['token'] =  $user->createToken($user->name)->plainTextToken;
        $success['name'] =  $user->name;
        return response()->json($success,202);
    }


    public function logout(Request $request)
    {
        $user= $request->user();
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        return response()->json("you are logout",200);
    }
}
