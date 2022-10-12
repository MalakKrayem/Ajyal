<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Attendence extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_days_id',
        'student_id',
        'status',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    //local scope
    public function scopeFilter(Builder $builder, $filters)
    {
        $builder->when($filters['status'] ?? false, function($builder, $value) {
            $builder->where('attendences.status', '=', $value);
        });
        $builder->when($filters['course_id'] ?? false, function($builder, $value) {
            $builder->whereExists(function ($query) use ($value) {
                $query->select(DB::raw(1))
                    ->from('course_days')
                    ->whereRaw('course_days.id = attendences.course_days_id')
                    ->where('course_days.course_id', '=', $value);
            });
        });
        $builder->when($filters['date'] ?? false, function($builder, $value) {
            $builder->where('course_days.date', '=', $value);
        });
    }

    public function course_day()
    {
        return $this->belongsTo(CourseDay::class, 'course_days_id', 'id');
    }
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
    //relation with course

}
