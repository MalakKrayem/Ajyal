<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsTo(Platform::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
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
}
