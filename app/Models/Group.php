<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class Group extends Model
{
    use  HasFactory, Notifiable,SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'image',
        'category_id',
        'project_id',
        'budget',
        'hour_count',
        'participants_count',
        'status',
        'start_date',
        'end_date'
    ];

    protected $hidden = [
        'image',
        'created_at', 'updated_at', 'deleted_at',
    ];

    protected $appends = [
        'image_url',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id')->withDefault();
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id')->withDefault();
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'group_id', 'id')->withDefault();
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
            'project_id' => null,
            'category_id' => null,
            'status' => 'draft',
        ], $filters);

        $builder->when($options['project_id'], function($builder, $value) {
            $builder->where('project_id', $value);
        });
        $builder->when($options['category_id'], function($builder, $value) {
            $builder->where('category_id', $value);
        });
        $builder->when($options['status'], function ($query, $status) {
            return $query->where('status', $status);
        });
    }
    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_group', 'group_id', 'student_id');
    }

    //Deleted Observer
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($group) {
            if($group->image){
                Storage::disk('public')->delete($group->image);
            }
        });
    }

    //Relationship with Freelance
    public function freelances()
    {
        return $this->hasMany(Freelance::class)->withDefault();
    }

}
