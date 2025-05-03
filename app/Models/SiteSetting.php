<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name', 'site_description', 'keywords', 'logo', 'favicon', 'sitemap_file',
        'email', 'phone', 'address', 'business_info',
        'maintenance_mode', 'site_type',
    ];
}

