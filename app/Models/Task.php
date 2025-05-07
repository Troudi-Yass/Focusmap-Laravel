<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'goal_id',
        'status',
        'due_date',
        'completed'
    ];

    protected $casts = [
        'completed' => 'boolean',
        'due_date' => 'date'
    ];

    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }
}