<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('settings')) {
            Schema::create('settings', function (Blueprint $table) {
                $table->id();
                $table->string('key', 100)->unique();
                $table->text('value')->nullable();
                $table->timestamps();
            });

            // Isi nilai bawaan dari settings.json bila ada
            $settingsPath = storage_path('app/settings.json');
            $defaults = [
                'store_name' => "Yan's Food",
                'store_address' => 'Bandung, Kp. Ciloa, RT.04/RW.10, Kec. Soreang',
                'store_phone' => '082221222936',
                'operational_hours' => 'Senin - Sabtu: 08:00 - 20:00 WIB',
                'qris_merchant_name' => "Yan's Food",
                'qris_image_path' => null,
            ];

            if (file_exists($settingsPath)) {
                $saved = json_decode(file_get_contents($settingsPath), true) ?? [];
                $defaults = array_merge($defaults, $saved);
            }

            foreach ($defaults as $k => $v) {
                DB::table('settings')->insertOrIgnore([
                    'key' => $k,
                    'value' => is_array($v) ? json_encode($v) : $v,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
