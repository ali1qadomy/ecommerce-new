<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    use HasFactory;
    protected $fillable=['name_en','name_ar'];

    public function admins(){
        return $this->belongsToMany(admins::class,'admin_role','admin_id','role_id');
    }
}
