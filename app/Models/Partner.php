<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;
    protected $fillable = ['name','description','logo'];

    public function projects()
    {
        return $this->belongsToMany(Project::class,'project_partner');
    }

    //creted observer for this model
    public static function boot()
    {
        parent::boot();
        // static::created(function ($partner) {
        //     ProjectPartner::create([
        //         'project_id' => $partner->projects()->first()->id,
        //         'partner_id' => $partner->id,
        //     ]);
        // });
    }

}
