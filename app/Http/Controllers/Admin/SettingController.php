<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::firstOrCreate([], [
            'app_name' => config('app.name', 'Stockify')
        ]);

        return view('admin.settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = Setting::firstOrCreate([]);

        $data = $request->only([
            'app_name', 'app_description', 'email', 
            'phone', 'address', 'facebook', 'instagram', 'whatsapp'
        ]);

        // Upload Logo
        if ($request->hasFile('app_logo')) {
            // Hapus logo lama jika ada
            if ($setting->app_logo) {
                Storage::disk('public')->delete($setting->app_logo);
            }
            $data['app_logo'] = $request->file('app_logo')->store('logos', 'public');
        }

        // Upload Favicon
        if ($request->hasFile('app_favicon')) {
            if ($setting->app_favicon) {
                Storage::disk('public')->delete($setting->app_favicon);
            }
            $data['app_favicon'] = $request->file('app_favicon')->store('favicons', 'public');
        }

        $setting->update($data);

        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan!');
    }
}