<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'user_id',
        'month',
        'year',
        'basic_salary',
        'salary_amount',
        'net_salary',
        'total_days',
        'working_days',
        'present_days',
        'total_office_time',
        'total_worked_time',
        'half_days',
        'late_days',
        'paid_leaves',
        'unpaid_leaves',
        'holiday_count',
        'payment_date',
        'status',
        'created_by',
        'updated_by',
    ];

    // Relasi dengan model Company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan model BasicSalary
    public function basicSalary()
    {
        return $this->hasOne(BasicSalary::class, 'user_id', 'user_id');
    }

    // Relasi dengan user yang membuat payroll
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relasi dengan user yang memperbarui payroll
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
