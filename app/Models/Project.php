<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;


class Project extends Model
{
    use  HasFactory, Notifiable,SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'budget',
        'status',
        'start_date',
        'end_date',
    ];
    protected $hidden = [
        'image',
    ];

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

        $builder->when($filters['title'] ?? false, function($builder, $value) {
            $builder->where('categories.title', 'LIKE', "%{$value}%");
        });

        $builder->when($filters['status'] ?? false, function($builder, $value) {
            $builder->where('categories.status', '=', $value);
        });

    }

    public function partners()
    {
        return $this->belongsToMany(Partner::class,'project_partner');
    }
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
