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
}
