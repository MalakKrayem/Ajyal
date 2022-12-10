<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Notification extends Model
{
    use HasFactory,Notifiable,HasApiTokens;

    protected $table="notifications";
    protected $fillable = [
        'id',
        'notifiable_id',
        'notifiable_type',
        'type',
        'data',
        'reat_at'
    ]; 

    
}