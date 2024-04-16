<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;
    protected $table = 'category';

    protected $fillable=['category_name_en','category_name_ar','parent','active'];

    public function getCategories($locale, $conditions = [])
    {
        $query = $this->select('id', 'category_name_' . $locale . ' AS name', 'parent', 'active');
        if (!empty($conditions)) {
            foreach ($conditions as $column => $value) {
                $query->where($column, $value);
            }
        }
        return $query->paginate(10);
    }

}
