<?php

namespace App\Http\Controllers\api\Product;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\apiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryProductsController extends Controller
{
    use apiResponse;

    public function categoryProducts(Category $category)
    {
       $products = $category->products;
        return $this->showAll($products );
    }

}
