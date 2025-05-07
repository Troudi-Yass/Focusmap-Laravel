<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'deadline',
        'priority',
        'progress',
        'status',
        'user_id',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    protected $appends = [
        'formatted_status',
        'status_color',
        'progress_color',
        'is_overdue',
        'user_name' // Add user_name to appended attributes
    ];

    public const STATUSES = [
        'not_started' => 'Not Started',
        'just_started' => 'Just Started',
        'on_track' => 'On Track',
        'in_progress' => 'In Progress',
        'almost_done' => 'Almost Done',
        'completed' => 'Completed'
    ];

    public function getFormattedStatusAttribute(): string
    {
        return self::STATUSES[$this->status] ?? 'Unknown';
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'just_started' => 'bg-blue-500',
            'on_track' => 'bg-yellow-500',
            'in_progress' => 'bg-orange-500',
            'almost_done' => 'bg-green-500',
            'completed' => 'bg-gray-500',
            default => 'bg-gray-400'
        };
    }

    public function getProgressColorAttribute(): string
    {
        return match(true) {
            $this->progress <= 25 => 'text-blue-500',
            $this->progress <= 50 => 'text-yellow-500',
            $this->progress <= 75 => 'text-orange-500',
            $this->progress < 100 => 'text-green-500',
            default => 'text-gray-500'
        };
    }

    public function getIsOverdueAttribute(): bool
    {
        if (!$this->deadline) return false;
        return !$this->completed && now()->startOfDay()->gt($this->deadline);
    }

    public function getUserNameAttribute()
    {
        return $this->user ? $this->user->name : null;
    }

    public function updateStatus(): void
    {
        $this->status = match(true) {
            $this->progress <= 25 => 'just_started',
            $this->progress <= 50 => 'on_track',
            $this->progress <= 75 => 'in_progress',
            $this->progress < 100 => 'almost_done',
            default => 'completed'
        };
        $this->save();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    protected static function newFactory()
    {
        return \Database\Factories\GoalFactory::new();
    }
}