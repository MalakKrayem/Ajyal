<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_id',
        'activity_type_id',
        'title',
        'description',
        'image',
        'date'
    ];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function activityType()
    {
        return $this->belongsTo(ActivitiesType::class);
    }
}
