<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class otpModel extends Model
{
    // Define the table name used by the OTP package
    protected $table = 'otps';

    // If the table doesn't have timestamps, disable them
//    public $timestamps = false;

    // If needed, specify fillable fields
    protected $fillable = ['id', 'identifier', 'token' ,'validity', 'valid' ,'created_at' , 'updated_at'];
}
