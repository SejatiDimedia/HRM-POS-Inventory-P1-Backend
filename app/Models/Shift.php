<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'shift_name',
        'clock_in_time',
        'clock_out_time',
        'late_mark_after',
        'early_clock_in_time',
        'allow_clock_out_till',
        'self_clocking',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
