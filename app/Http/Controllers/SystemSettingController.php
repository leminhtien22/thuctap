<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuration;

class SystemSettingController extends Controller
{
    public function index()
    {
        $configurations = Configuration::all()->keyBy('config_key');
        return view('admin.system_settings.index', compact('configurations'));
    }

    public function update(Request $request)
{
    // Validation cho thông tin liên hệ
    $request->validate([
        'site_name' => 'required|string|max:255',
        'contact_email' => 'required|email',
        'contact_phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'footer_text' => 'nullable|string|max:500',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'facebook' => 'nullable|url',
        'instagram' => 'nullable|url',
        'tiktok' => 'nullable|url',
        'youtube' => 'nullable|url',
    ]);

    // Cập nhật các cấu hình thông thường (trừ logo)
    foreach ($request->except('_token', 'logo') as $key => $value) {
        Configuration::updateOrCreate(
            ['config_key' => $key],
            ['value' => $value]
        );
    }

    // Xử lý upload logo
    if ($request->hasFile('logo')) {
        $logoPath = $request->file('logo')->store('public/logos');
        $logoUrl = \Storage::url($logoPath); // /storage/logos/xxx.png

        Configuration::updateOrCreate(
            ['config_key' => 'logo'],
            ['value' => $logoUrl]
        );
    }

    return redirect()->route('admin.system_settings')->with('success', 'Cập nhật thành công!');
}


}
