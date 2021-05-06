<?php

namespace App\Http\Controllers\api\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\apiResponse;
use Illuminate\Http\Request;

class CategorySellerController extends Controller
{
    use apiResponse;
    public function categorySellers(Category $category)
    {
       $sellers = $category->sellers;
       //return $sellers;
       return $this->showAll($sellers);
    }
}
