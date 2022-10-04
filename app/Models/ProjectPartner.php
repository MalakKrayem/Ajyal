<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectPartner extends Model
{
    use HasFactory;
    protected $table = 'project_partner';
    protected $fillable = ['project_id','partner_id'];
}
