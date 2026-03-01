<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('gallery_images', function (Blueprint $table) {
            if (!Schema::hasColumn('gallery_images', 'caption')) {
                $table->string('caption')->nullable()->after('image_path');
            }
            if (!Schema::hasColumn('gallery_images', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('caption');
            }
        });
    }

    public function down(): void
    {
        Schema::table('gallery_images', function (Blueprint $table) {
            $table->dropColumn(['caption', 'sort_order']);
        });
    }
};
