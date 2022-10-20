<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;


class Course extends Model
{
    use  HasFactory, Notifiable,SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'image',
        'category_id',
        'mentor_id',
        'budget',
        'hour_count',
        'participants_count',
        'status',
        'start_date',
        'end_date'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    protected $appends = [
        'image_url',
    ];
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id')->withDefault();
    }

    public function scopeDraft(Builder $builder)
    {
        $builder->where('status', '=', 'draft');
    }
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return 'https://media.istockphoto.com/photos/finding-solution-for-a-problem-concept-with-jigsaw-puzzle-pieces-picture-id1194677324?s=612x612';
        }
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }

    public function scopeFilter(Builder $builder, $filters)
    {
        $options = array_merge([
            'group_id' => null,
           // 'mentor_id' => null,
            'status' => 'draft',
        ], $filters);

        $builder->when($options['group_id'], function($builder, $value) {
            $builder->where('group_id', $value);
        });
        // $builder->when($options['mentor_id'], function($builder, $value) {
        //     $builder->where('mentor_id', $value);
        // });
        $builder->when($options['status'], function ($query, $status) {
            return $query->where('status', $status);
        });
    }
    //relation with course day
    public function course_days()
    {
        return $this->hasMany(CourseDay::class, 'course_id', 'id')->withDefault();
    }
    //relation with rate
    public function rates()
    {
        return $this->hasMany(Rate::class, 'course_id', 'id')->withDefault();
    }

    //Relation with mentor
    public function mentor()
    {
        return $this->belongsTo(Mentor::class, 'mentor_id', 'id')->withDefault();
    }

}
