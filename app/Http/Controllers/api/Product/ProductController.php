<?php

namespace App\Http\Controllers\api\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Traits\apiResponse;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class ProductController extends Controller
{
    use apiResponse ;

    public function index()
    {

        if ($this->assurence()->first()->name  != auth()->user()->name)
            return $this->errorResponse('unauthenticated you try to modify another user you do not have permission ' , 404);

        $products = Product::where('seller_id' , auth()->user()->id)->get();
        return $this->showAll($products , 200);
    }

    public function store(Request $request)
    {

        if (isset($this->assurence()->first()->name) != auth()->user()->name)
            return $this->errorResponse('unauthenticated you try to modify another user you do not have permission ' , 404);

        $this->validate($request, $this->validStore());
        $product = Product::create([
            "name" => $request->name,
            "description" => $request->description,
            "salary" => $request->salary,
            "available" => $request->available,
            "category_id" => $request->category_id,
            "seller_id" => auth()->user()->id,
            "time_to_Preparation" => $request->time_to_Preparation
        ]);

        return $this->showOne($product , 202) ;
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return $this->showOne($product , 200);
    }


    public function update(Request $request, $id)
    {
        if (isset($this->assurence()->first()->name) != auth()->user()->name)
            return $this->errorResponse('unauthenticated you try to modify another user you do not have permission ' , 404);

        $product = Product::findOrFail($id) ;
        if ($product->seller_id != auth()->user()->id)
            return $this->errorResponse('you have not such as product' , 404);

       $this->validate($request, $this->validUpdate());
        $product->fill($request->all());
        $product->update();
        return $this->showOne($product ,202);

    }


    public function destroy($id)
    {
        //
    }

    private function validStore()
    {
        return   [
            'name' => 'required|string',
            'description' =>'required' ,
            'salary' => 'required|integer',
            'available' => 'required|in:0,1',
            'category_id' => 'required' ,
            'time_to_Preparation' =>'required' ,
        ];
    }
    private function validUpdate()
    {
        return   [
            'name' => 'string',
            'salary' => 'integer',
            'available' => 'in:0,1',
        ];
    }


    private function assurence()
    {
        return PersonalAccessToken::where( 'name' ,'LIKE', auth()->user()->name )->
        Where('tokenable_id','LIKE',auth()->user()->id )->
        where('tokenable_type' , 'App\Models\Seller')->
        get();

    }


}
