<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->string('video_url')->nullable()->after('thumbnail');
        });

        Schema::table('announcements', function (Blueprint $table) {
            $table->string('video_url')->nullable()->after('content');
        });

        Schema::table('kajian_schedules', function (Blueprint $table) {
            $table->string('video_url')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn('video_url');
        });
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn('video_url');
        });
        Schema::table('kajian_schedules', function (Blueprint $table) {
            $table->dropColumn('video_url');
        });
    }
};
