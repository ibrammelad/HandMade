<?php

namespace App\Http\Controllers\api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\apiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Sanctum\PersonalAccessToken;

class UserController extends Controller
{
    use apiResponse ;

    public function index()
    {
        $users = User::all();
        return $this->showAll($users, 200);
    }



    public function show($id)
    {
        $user = User::findOrFail($id);
        return $this->showOne($user , 200);
    }

    public function update(Request $request, $id)
    {

        $rules = [
            'name'  => 'string',
            'phone' =>Rule::unique('users', 'phone')->ignore($id),
            'email' =>Rule::unique('users', 'email')->ignore($id),

        ];
        $authenticated = PersonalAccessToken::where( 'name' ,'LIKE', auth()->user()->name )->Where('tokenable_id','LIKE',auth()->user()->id )->get();
        if (auth()->user()->id != $id &&  $authenticated ->first()->name != User::findOrFail($id)->name)
        {
            return $this->errorResponse('unauthenticated you try to modify another user you do not have permission ' , 404);
        }
        $this->validate($request , $rules);
        $user= User::findOrFail($id);
        $user->fill($request->all());
        $user->update();

        return $this->showOne($user ,202);
    }

    public function me()
    {
        $user = auth()->user();
        return $this->showOne($user , 200);
    }

    public function destroy($id)
    {
        //
    }
}
