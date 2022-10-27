<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LandingPage extends Model
{
    use HasFactory;
    protected $fillable = [
        'key',
        'value',
    ];

    //image atturibute
    public function getDataShapeAttribute()
    {
        $data=json_decode($this->value);
        $images_path=[];
        $images=$data->images;
        foreach($images as $image){
            $images_path[]= asset('storage/' . $image);
        }
        $data=['content'=> $data->content,'images'=>$images_path];
        return $data;
    }
}
