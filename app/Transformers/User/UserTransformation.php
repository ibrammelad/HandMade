<?php

namespace App\Transformers\User;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformation extends TransformerAbstract
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
    public function transform(User $user)
    {
        return [
            'identifier' => $user->id ,
            'name' => $user->name,
            'email' => $user->email ,
            'number phone'  => $user->phone ,
            'latitude of address' =>  $user->latitude,
            'longitude of address' => $user->longitude,
            'email verified' =>$user->verified ==0 ? 'verified' :'unverified',
            'creationDate' => $user->created_at	,
            'LastChange' => $user->updated_at	,
            'links' => [
                'rel' => 'self',
                'href' => route('users.show' , $user->id),
            ]
        ];
    }
}
