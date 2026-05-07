<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'title',
        'description',
        'field',
        'city',
        'duration',
        'start_date',
        'requirements',
        'is_paid',
        'salary',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'is_paid' => 'boolean',
        'salary' => 'decimal:2',
    ];

    // Relations
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}