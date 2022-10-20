<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'course_id',
        'rate',
        'notes',
    ];

    //Relation with student
    public function student()
    {
        return $this->belongsTo(Student::class)->withDefault();
    }
    //Relation with course
    public function course()
    {
        return $this->belongsTo(Course::class)->withDefault();
    }
}
