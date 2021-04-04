<?php

namespace App\Models;

use App\Transformers\Product\ProductTransformer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name' , 'description'  , 'photo' , 'salary' , 'available' , 'category_id' ,'seller_id' , 'time_to_Preparation'
    ];

    public $transformer = ProductTransformer::class;

    public function scopeActive($query)
    {
        return $query->where('available' , 1);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class , 'seller_id' , 'id') ;
    }

    public function category()
    {
        return $this->belongsTo(Category::class , 'category_id' , 'id') ;
    }

}
