<?php

namespace App\Models;

use App\Transformers\User\UserTransformation;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory,HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $transformer = UserTransformation::class;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'latitude',
        'longitude',
        'verified',
        'password',
        'created_at',
        'updated_at'
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


    public function scopeSelection($query)
    {
        return $query->select('id','name',
            'email',
            'phone',
            'latitude',
            'longitude',
            'created_at',
            'updated_at'
        );
    }
}
