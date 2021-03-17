<?php

namespace App\Http\Controllers\api\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {

        $user = Seller::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;
        return response()->json($success,202);
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
            'available_seller' => 'required|in:0,1'
        ]);

        if($validator->fails()){
            return response()->json( $validator->errors() , 404);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = Seller::create($input);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;
        return response()->json($success,202);
    }


    public function logout()
    {
        $user=Auth::guard('seller')->user();
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        return response()->json("you are logout",200);
    }
}
