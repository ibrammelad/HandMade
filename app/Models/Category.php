<?php

namespace App\Models;

use App\Transformers\Category\CategoryTransformation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillablea =[
        'name' , 'description' , 'photo' , 'available' ,
    ];

    public $transformer = CategoryTransformation::class;


    public function scopeActive($query)
    {
        return $query->where('available' , 1);
    }


    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function sellers()
    {
        return $this->belongsToMany(Seller::class);
    }

}



