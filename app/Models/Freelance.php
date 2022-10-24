<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Freelance extends Model
{
    use HasFactory;
    protected $fillable = [
        'platform_id',
        'student_id',
        'group_id',
        'job_title',
        'job_description',
        'job_link',
        'attachment',
        'salary',
        'client_feedback',
        'status',
        'notes',
    ];

    public function platform()
    {
        return $this->belongsTo(Platform::class)->withDefault();
    }

    public function student()
    {
        return $this->belongsTo(Student::class)->withDefault();
    }

    public function group()
    {
        return $this->belongsTo(Group::class)->withDefault();
    }
    //Filter
    public function scopeFilter(Builder $builder, $filters)
    {
        $builder->when($filters['platform_id'] ?? false, function($builder, $value) {
            $builder->where('freelances.platform_id', 'LIKE', "%{$value}%");
        });
        $builder->when($filters['group_id'] ?? false, function($builder, $value) {
            $builder->where('freelances.group_id', 'LIKE', "%{$value}%");
        });
        $builder->when($filters['status'] ?? false, function($builder, $value) {
            $builder->where('freelances.status', '=', $value);
        });
    }

    public function getAttachmentUrlAttribute()
    {
        if (!$this->attachment) {
            return 'https://img.favpng.com/2/12/12/computer-icons-portable-network-graphics-user-profile-avatar-png-favpng-L1ihcbxsHbnBKBvjjfBMFGbb7.jpg';
        }
        if(Str::startsWith($this->attachment, ['http://', 'https://']) ) {
            return $this->attachment;
        }

        return asset('storage/' . $this->attachment);
    }
}
