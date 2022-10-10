<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Gallery extends Model
{
    use  HasFactory, Notifiable,SoftDeletes;

    protected $fillable = [
        'description',
        'image',
        'course_id',

    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    protected $appends = [
        'image_url',
    ];
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
}
