<?php

namespace App\Models;

use App\Transformers\Seller\SellerTransformation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Seller extends Authenticatable
{
    use HasFactory,HasApiTokens ,Notifiable;
    protected $guard = 'seller';

    use HasFactory,HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public  $transformer = SellerTransformation::class;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'latitude',
        'longitude',
        'available_seller',
        'photo',
        'verified',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getId()
    {
        return $this->id ;
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }


    public function scopeSelection($query)
    {
        return $query->select('id','name',
            'email',
            'phone',
            'latitude',
            'longitude',
            'available_seller',
            'verified',
            'created_at',
            'updated_at'
        );
    }

    public function categories()
    {
        return $this->belongsToMany(category::class);
    }


}
