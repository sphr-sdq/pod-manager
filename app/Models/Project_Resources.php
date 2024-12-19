<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project_Resources extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function project()
    {
        $this->belongsTo(Projects::class , 'project_id' ,'id');
    }
}
