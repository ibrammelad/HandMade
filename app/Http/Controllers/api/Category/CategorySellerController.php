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
       $online=[];
        foreach ($sellers as $index =>$seller) {
            if ($seller->online == '1' )
            {
                $online[$index] = $seller;
            }
            else
                continue;
       }

        $onlineSellers  =collect($online);
       return $this->showAll($onlineSellers);
    }
}
