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
            'email' => 'email|unique:sellers',
            'phone' =>'unique:sellers',
            'password' => 'confirmed',
            'available_seller' => 'in:0,1'
        ];
    }

    public function destroy($id)
    {

    }
}
