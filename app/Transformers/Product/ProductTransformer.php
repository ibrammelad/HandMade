<?php

namespace App\Transformers\Product;

use App\Models\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
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
    public function transform(Product $product)
    {
        return [
            'identifier' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'image' => $product->photo,
            'fees' => $product->salary,
            'active' => $product->available,
            'category' => $product->category_id,
            'seller' => $product->seller_id,
            'time_to_Preparation' => $product->time_to_Preparation,
            'links' => [
                'rel' => 'self',
                'href' => route('products.show' , $product->id),
            ]
        ];
    }
}
