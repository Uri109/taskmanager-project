<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public const STATUSES = ['todo', 'in_progress', 'done'];

    public const PRIORITIES = ['low', 'medium', 'high'];

    protected $fillable = ['title', 'description', 'status', 'priority', 'due_date', 'completed_at'];

    protected $casts = ['due_date' => 'date', 'completed_at' => 'datetime'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
