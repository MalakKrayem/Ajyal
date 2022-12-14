<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class StudentGroup extends Pivot
{
    use HasFactory;
    protected $table = 'student_group';
    protected $fillable = ['group_id','student_id'];

    public function student(){
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
}