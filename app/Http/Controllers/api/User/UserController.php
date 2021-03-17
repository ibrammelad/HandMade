<?php

namespace App\Http\Controllers\api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\apiResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use apiResponse ;

    public function index()
    {
        $users = User::all();
        return $this->showAll($users, 200);
    }

    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        $user = User::findOrFail($id);
        return $this->showOne($user , 200);
    }

    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
