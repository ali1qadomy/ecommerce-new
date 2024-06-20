<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    protected $table = 'admin_role';

    protected $fillable = ['admin_id', 'role_id'];
}
