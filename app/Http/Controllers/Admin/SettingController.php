<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    protected function getSettingsPath(): string
    {
        return storage_path('app/settings.json');
    }

    protected function getSettings(): array
    {
        $path = $this->getSettingsPath();
        if (File::exists($path)) {
            return json_decode(File::get($path), true) ?? [];
        }

        return [
            'store_name' => "Yan's Food",
            'store_address' => 'Jl. Babakan Tarogong No. 12, Bandung',
            'store_phone' => '081234567890',
            'operational_hours' => 'Senin - Sabtu: 08:00 - 20:00 WIB',
            'shopeefood_url' => 'https://shopee.co.id/universal-link/now-food',
            'gofood_url' => 'https://gofood.link/u/yansfood',
            'grabfood_url' => 'https://food.grab.com/id/id/restaurant/yans-food',
        ];
    }

    public function index()
    {
        $settings = $this->getSettings();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'store_name' => ['required', 'string', 'max:255'],
            'store_address' => ['required', 'string', 'max:255'],
            'store_phone' => ['required', 'string', 'max:50'],
            'operational_hours' => ['required', 'string', 'max:255'],
            'shopeefood_url' => ['nullable', 'url', 'max:255'],
            'gofood_url' => ['nullable', 'url', 'max:255'],
            'grabfood_url' => ['nullable', 'url', 'max:255'],
        ]);

        $path = $this->getSettingsPath();
        File::ensureDirectoryExists(dirname($path));
        File::put($path, json_encode($validated, JSON_PRETTY_PRINT));

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan informasi usaha & link pesan online berhasil disimpan!');
    }
}
