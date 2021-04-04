<?php

namespace App\Http\Controllers\api\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Seller;
use App\Traits\apiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Collection\Collection;

class ProductSellerController extends Controller
{
    use apiResponse;
    public function timeline()
    {
        $lat =auth()->user()->latitude;
        $lng =auth()->user()->longitude;
        $model = Seller::Selection();
        $model->addSelect(DB::raw("acos(cos(" . $lat . "*pi()/180)*cos(latitude*pi()/180)*
        cos(" . $lng . "*pi()/180-longitude*pi()/180)+
        sin(" . $lat . "*pi()/180)*sin(latitude * pi()/180))
        * 6367000 AS distance"))->orderBy('distance','ASC');
        $sellers  = $model->get();
        $products=[];
        foreach ($sellers as $index=>$seller)
        {
             $products=$seller->whereHas('products')->with('products')->get()->pluck('products')->collapse();
        }
        $products =collect($products);
        return $this->showAll($products);
    }
}
