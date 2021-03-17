<?php

namespace App\Http\Controllers\api\Category;

use App\Http\Controllers\Controller;
use App\Traits\apiResponse;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    use apiResponse;
    public function index()
    {
        $categories = Category::all();
        return $this->showAll($categories ,200);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return $this->showOne($category , 200);
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
