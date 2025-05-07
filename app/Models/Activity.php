<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'goal_id',
        'type',
        'description',
        'changes', // JSON field to track changes
        'ip_address',
        'user_agent',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'changes' => 'array',
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Activity types constants
     *
     * @var array
     */
    public const TYPES = [
        'goal_created' => 'Goal Created',
        'goal_updated' => 'Goal Updated',
        'goal_completed' => 'Goal Completed',
        'task_created' => 'Task Created',
        'task_completed' => 'Task Completed',
        'progress_updated' => 'Progress Updated',
        'note_added' => 'Note Added',
        'milestone_reached' => 'Milestone Reached',
    ];

    /**
     * Get the user that performed the activity.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the goal associated with the activity.
     */
    public function goal(): BelongsTo
    {
        return $this->belongsTo(Goal::class);
    }

    /**
     * Scope for goal-related activities.
     */
    public function scopeForGoal($query, $goalId)
    {
        return $query->where('goal_id', $goalId);
    }

    /**
     * Scope for user activities.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope for recent activities.
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Get the formatted type.
     */
    public function getFormattedTypeAttribute(): string
    {
        return self::TYPES[$this->type] ?? $this->type;
    }

    /**
     * Create a new activity log.
     */
    public static function log(string $type, string $description, array $changes = [], ?Model $model = null): self
    {
        $goalId = null;
        if ($model instanceof Goal) {
            $goalId = $model->getKey();
        } elseif ($model !== null && property_exists($model, 'goal_id')) {
            $goalId = $model->goal_id;
        }

        return static::create([
            'user_id' => auth()->id(),
            'goal_id' => $goalId,
            'type' => $type,
            'description' => $description,
            'changes' => $changes,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        return \Database\Factories\ActivityFactory::new();
    }
}