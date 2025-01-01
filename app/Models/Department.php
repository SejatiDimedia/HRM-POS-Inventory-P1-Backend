<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['department_name', 'company_id', 'created_by', 'description'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
