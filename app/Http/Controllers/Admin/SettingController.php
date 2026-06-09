<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = CompanySetting::pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string',
            'company_phone' => 'required|string',
            'company_address' => 'required|string',
            'bank_name' => 'required|string',
            'bank_account' => 'required|string',
            'bank_owner' => 'required|string',
            'qris_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $inputs = $request->except(['_token', 'qris_image']);

        foreach ($inputs as $key => $value) {
            CompanySetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        if ($request->hasFile('qris_image')) {
            $oldQris = CompanySetting::where('key', 'qris_image')->first();
            if ($oldQris && $oldQris->value) {
                Storage::disk('public')->delete($oldQris->value);
            }

            $path = $request->file('qris_image')->store('settings', 'public');
            CompanySetting::updateOrCreate(['key' => 'qris_image'], ['value' => $path]);
        }

        return back()->with('success', 'Pengaturan perusahaan berhasil diperbarui!');
    }
}
