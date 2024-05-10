<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'color',
        'slug'
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function user_tasks()
    {
        return $this->belongsToMany(Task::class, 'task_user')
            ->where('tasks.workspace_id', session()->get('workspace_id'));
    }
}
