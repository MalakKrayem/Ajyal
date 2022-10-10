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
