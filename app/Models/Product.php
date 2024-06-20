<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table='products';
    protected $fillable=['name_en','name_ar','description_en','description_ar','category_id','active','image_url'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function image()
    {
        return  $this->morphMany(image::class,'imagable');
    }

}
