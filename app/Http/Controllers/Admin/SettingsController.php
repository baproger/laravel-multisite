<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy('group')->orderBy('id')->get()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            // Обработка загрузки файлов
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $old = Setting::get($key);
                if ($old) Storage::disk('public')->delete($old);
                $value = $file->store('settings', 'public');
            }

            Setting::set($key, $value);
        }

        Setting::clearCache();

        return back()->with('success', 'Настройки сохранены');
    }
}
