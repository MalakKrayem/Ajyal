<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseDay extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_id',
        'date',
    ];
    //filter for course_id and date
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['course_id'] ?? false, function ($query, $course_id) {
            $query->where('course_id', $course_id);
        });
        $query->when($filters['date'] ?? false, function ($query, $date) {
            $query->where('date', $date);
        });
    }

    //relation with course
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id')->withDefault([
            'title' => 'Deleted'
        ]);
    }
    public function attendences()
    {
        return $this->hasMany(Attendence::class, 'course_days_id', 'id');
    }

}
