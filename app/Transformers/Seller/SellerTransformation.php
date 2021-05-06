<?php

namespace App\Transformers\Seller;

use App\Models\Seller;
use League\Fractal\TransformerAbstract;

class SellerTransformation extends TransformerAbstract
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
    public function transform(Seller $seller)
    {
        return [
            'identifier' => $seller->id ,
            'name' => $seller->name,
            'photo' => $seller->photo,
            'latitude of address' =>  $seller->latitude,
            'longitude of address' => $seller->longitude,
            'distance' => round($seller->distance,3),
            'is active seller '  =>$seller->available_seller == 1 ? 'active' : 'inactive',
            'email verified' =>$seller->verified ==0 ? 'verified' :'unverified',
            'creationDate' => $seller->created_at	,
            'LastChange' => $seller->updated_at	,
            'links' => [
                'rel' => 'self',
                'href' => route('sellers.show' , $seller->id),
            ]
        ];
    }
}
