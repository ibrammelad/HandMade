<?php

namespace App\Http\Controllers\api\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Traits\apiResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use apiResponse ;

    public function index()
    {
        $products = Product::all();
        return $this->showAll($products , 200);
    }

    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        $product = Product::findOrFail($id);
        return $this->showOne($product , 200);
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
