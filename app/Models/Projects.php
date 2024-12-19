<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function namespace()
    {
        return $this->belongsTo(namespaces::class);
    }

    public function pod()
    {
        return $this->belongsTo(Pods::class);
    }

    public function project_resources()
    {
        return $this->hasMany(Project_Resources::class);
    }
}
