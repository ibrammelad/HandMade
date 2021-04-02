<?php

namespace App\Http\Controllers\api\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Traits\apiResponse;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    use apiResponse ;


    public function index()
    {
        $sellers = Seller::all();
        return $this->showAll($sellers , 200);
    }

    public function show($id)
    {
        $seller = Seller::findOrfail($id);
        return $this->showOne($seller , 200);
    }


    public function update(Request $request, $id)
    {

        $rules = [
            'name'  => 'string',
            'phone' =>'unique:sellers',
            'available_seller' => 'in:0,1'

        ];
        if (auth()->user()->id != $id)
        {
            return $this->errorResponse('unauthenticated you try to modify another seller you do not have permission ' , 404);
        }
        $this->validate($request , $rules);
        $seller = Seller::findOrFail($id);
        $seller->fill($request->all());
        $seller->update();

        return $this->showOne($seller ,202);


    }
    public function me()
    {
        $user = auth()->user();
        return $this->showOne($user , 200);
    }
    public function destroy($id)
    {

    }
}
