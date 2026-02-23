<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'home_contents';

    protected $fillable = ['key', 'value'];

    public $timestamps = true;
}
