<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    protected function getSettingsPath(): string
    {
        return storage_path('app/settings.json');
    }

    protected function getSettings(): array
    {
        $defaults = [
            'store_name' => "Yan's Food",
            'store_address' => 'Bandung, Kp. Ciloa, RT.04/RW.10, Kec. Soreang',
            'store_phone' => '082221222936',
            'operational_hours' => 'Setiap Hari: 08:00 - 22:00 WIB',
            'shopeefood_url' => 'https://shopee.co.id/universal-link/now-food/shop/20759614?deep_and_deferred=1&shareChannel=copy_link',
            'gofood_url' => 'https://gofood.link/a/Fj6y8Jy',
            'grabfood_url' => 'https://app.grab.com/s/07XMlcm7',
            'qris_merchant_name' => "YAN'S FOOD NASI GORENG, R",
            'qris_image_path' => file_exists(public_path('images/qris/qris-yansfood.jpeg')) ? 'images/qris/qris-yansfood.jpeg' : null,
        ];

        $path = $this->getSettingsPath();
        if (File::exists($path)) {
            $saved = json_decode(File::get($path), true) ?? [];
            $defaults = array_merge($defaults, $saved);
        }

        // Ambil data dari database Setting bila ada, jika masih nilai generic lama gantikan dengan direct link baru
        $legacyLinks = [
            'https://shopee.co.id/universal-link/now-food',
            'https://gofood.link/u/yansfood',
            'https://gofood.link',
            'https://food.grab.com/id/id/restaurant/yans-food',
            'https://food.grab.com',
        ];

        foreach (['shopeefood_url', 'gofood_url', 'grabfood_url'] as $linkKey) {
            $dbLink = Setting::get($linkKey);
            if ($dbLink && !in_array($dbLink, $legacyLinks)) {
                $defaults[$linkKey] = $dbLink;
            }
        }

        // Ambil data QRIS dari database Setting bila ada
        $dbQris = Setting::get('qris_image_path');
        if ($dbQris) {
            $defaults['qris_image_path'] = $dbQris;
        }

        $dbMerchant = Setting::get('qris_merchant_name');
        if ($dbMerchant) {
            $defaults['qris_merchant_name'] = $dbMerchant;
        }

        return $defaults;
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
            'shopeefood_url' => ['nullable', 'url', 'max:500'],
            'gofood_url' => ['nullable', 'url', 'max:500'],
            'grabfood_url' => ['nullable', 'url', 'max:500'],
            'qris_merchant_name' => ['nullable', 'string', 'max:100'],
            'qris_image' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
        ]);

        $settings = $this->getSettings();

        // Handle upload QRIS
        if ($request->hasFile('qris_image')) {
            $file = $request->file('qris_image');
            
            // Hapus file lama bila ada
            if (!empty($settings['qris_image_path'])) {
                $oldRel = str_replace('storage/', '', $settings['qris_image_path']);
                Storage::disk('public')->delete($oldRel);
            }

            $filename = 'qris_' . Str::random(12) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('qris', $filename, 'public');
            $publicPath = 'storage/' . $path;

            $validated['qris_image_path'] = $publicPath;
            Setting::set('qris_image_path', $publicPath);
        } else {
            $validated['qris_image_path'] = $settings['qris_image_path'] ?? null;
        }

        if (isset($validated['qris_merchant_name'])) {
            Setting::set('qris_merchant_name', $validated['qris_merchant_name']);
        }

        // Hapus file dari array validated sebelum simpan ke json
        unset($validated['qris_image']);

        $path = $this->getSettingsPath();
        File::ensureDirectoryExists(dirname($path));
        File::put($path, json_encode($validated, JSON_PRETTY_PRINT));

        // Simpan juga ke database Setting
        foreach ($validated as $k => $v) {
            Setting::set($k, $v);
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan toko dan konfigurasi QRIS pembayaran berhasil disimpan!');
    }
}
