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


    ////// all products can users see ////
    public function productsUsers()
    {
        $products =Product::all();

        return $this->showAll($products);
    }


    /////////  my products //////
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
        $data = $request->except('photo');

        if ($request->hasFile('photo'))
        {
            $image  = $request->file('photo');
            $new_name = $data['name'].'.'.$image->getClientOriginalExtension();
            $image->move(public_path("images/product") ,$new_name );
            $data['photo'] = $new_name;
        }
        $data['seller_id'] =auth()->user()->id;
        $product = Product::create($data);
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
            return $this->errorResponse('unauthenticated ' , 404);

        $product = Product::findOrFail($id) ;
        if ($product->seller_id != auth()->user()->id)
            return $this->errorResponse('you have not such as product' , 404);

       $this->validate($request, $this->validUpdate());
        $product->fill($request->all());
        $product->update();
        return $this->showOne($product ,202);

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
            ''
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
