<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name_en','name_ar','price','code','quantity','status',
    'image','brand_id','subcategory_id','details_en','details_ar'];

    protected function image(): Attribute
    {
        return Attribute::make(
            get: function($value){
                return asset('images/products/'.$value);
            },
        );
    }

    // protected function image(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => ucfirst($value),
    //     );
    // }
}
