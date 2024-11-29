<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class namespaces extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'name', 'slug'];

    public function getUser()
    {
        return $this->belongsTo(User::class);
    }
}
