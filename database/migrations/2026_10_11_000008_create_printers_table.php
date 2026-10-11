<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('printers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('connection_type', ['bluetooth', 'usb', 'network'])->default('usb');
            $table->enum('paper_width', ['58mm', '80mm'])->default('58mm');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->json('settings')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('printers');
    }
};
