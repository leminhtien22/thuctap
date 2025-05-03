<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\SiteSetting;

class SiteSettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::firstOrCreate([]);
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'site_name' => 'nullable|string',
            'site_description' => 'nullable|string',
            'keywords' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'business_info' => 'nullable|string',
            'maintenance_mode' => 'boolean',
            'site_type' => 'in:full,simple',
            'logo' => 'nullable|image',
            'favicon' => 'nullable|image',
            'sitemap_file' => 'nullable|file|mimes:xml',
        ]);

        $settings = SiteSetting::first();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('settings', 'public');
        }

        if ($request->hasFile('favicon')) {
            $data['favicon'] = $request->file('favicon')->store('settings', 'public');
        }

        if ($request->hasFile('sitemap_file')) {
            $data['sitemap_file'] = $request->file('sitemap_file')->store('settings', 'public');
        }

        $settings->update($data);
        return back()->with('success', 'Cập nhật thành công!');
    }
}

