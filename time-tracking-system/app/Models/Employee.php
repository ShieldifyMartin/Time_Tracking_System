<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'hired_since',
        'salary',
        'working_hours_per_day',
        'total_hours_worked',
        'job_title',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'hired_since' => 'date',
        'salary' => 'float',
        'working_hours_per_day' => 'integer',
        'total_hours_worked' => 'integer',
        'is_active' => 'boolean',
    ];

    public function getEarnedSalaryAttribute()
    {
        $hourlyRate = $this->salary / ($this->working_hours_per_day * 22);
        return '$' . number_format($hourlyRate * $this->total_hours_worked, 2);
    }
}