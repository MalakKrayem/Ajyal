<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Partner extends Model
{
    use HasFactory;
    protected $fillable = ['name','description','logo'];
    protected $hidden = ['created_at','updated_at'];

    public function projects()
    {
        return $this->belongsToMany(Project::class,'project_partner');
    }

    //Delete Observer
    public static function boot()
    {
        parent::boot();
        static::deleted(function ($partner) {
            if($partner->logo){
                Storage::disk('public')->delete($partner->logo);
            }
        });
    }

}
