<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasicSalary extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'user_id',
        'basic_salary',
    ];

    // Define relationships if needed
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
