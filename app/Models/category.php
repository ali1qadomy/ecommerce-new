<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;
    protected $table = 'category';

    protected $fillable=['category_name_en','category_name_ar','active'];

    public function getCategories($locale, $conditions = [])
    {
        $query = $this->select('id', 'category_name_' . $locale . ' AS name', 'parent', 'active');
        if (!empty($conditions)) {
            foreach ($conditions as $column => $value) {
                $query->where($column, $value);
            }
        }
        return $query;
    }
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent');
    }

}
