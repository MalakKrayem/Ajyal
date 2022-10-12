<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Platform extends Model
{
    use HasFactory;
    protected $fillable = ['name','job_count'];

    //Deleted observer
    protected static function booted()
    {
        static::deleted(function ($platform) {
            if ($platform->image) {
                Storage::disk('public')->delete($platform->image);
            }
        });
    }

    //Relationship with Freelance
    public function freelances()
    {
        return $this->hasMany(Freelance::class);
    }
}
