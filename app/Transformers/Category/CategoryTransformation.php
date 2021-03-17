<?php

namespace App\Transformers\Category;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformation extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Category $category)
    {
        return [
            'name' => $category->name ,
            'details' =>$category->description,
            'image'=>$category->photo ,
            'active'=>$category->available ,
            'creationDate' => $category->created_at	,
            'LastChange' => $category->updated_at	,

            'links' => [
                'rel'=>'self',
                'href' => route('categories.show' , $category->id),
            ]
        ];
    }
}
