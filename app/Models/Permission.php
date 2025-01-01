<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'display_name', 'module_name', 'description',];

    public function role()
    {
        return $this->belongsToMany(\App\Models\Role::class, 'permission_roles');
    }
}
