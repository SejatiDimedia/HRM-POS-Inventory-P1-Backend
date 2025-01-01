<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['company_id','role_name', 'display_name', 'description'];

    public function permissions()
    {
        return $this->belongsToMany(\App\Models\Permission::class, 'permission_roles');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_users');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
