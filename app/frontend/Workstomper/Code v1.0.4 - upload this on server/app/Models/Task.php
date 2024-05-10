<?php

namespace App\Models;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class Task extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    protected $fillable = [
        'title',
        'status_id',
        'project_id',
        'start_date',
        'due_date',
        'description',
        'user_id',
        'workspace_id',
        'created_by'
    ];

    public function registerMediaCollections(): void
    {
        $media_storage_settings = get_settings('media_storage_settings');
        $mediaStorageType = $media_storage_settings['media_storage_type'] ?? 'local';
        if ($mediaStorageType === 's3') {
            $this->addMediaCollection('task-media')->useDisk('s3');
        } else {
            $this->addMediaCollection('task-media')->useDisk('public');
        }
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function clients()
    {
        return $this->project->client;
    }
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function getresult()
    {
        return substr($this->title, 0, 100);
    }

    public function getlink()
    {
        return str('/tasks/information/' . $this->id);
    }

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }
}
