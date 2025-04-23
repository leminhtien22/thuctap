<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $table = 'configurations';  // Đảm bảo đúng tên bảng

    protected $fillable = ['config_key', 'value'];

    public $timestamps = false;
}