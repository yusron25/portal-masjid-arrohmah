<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ── Sliders: add missing columns and standardize names ──
        Schema::table('sliders', function (Blueprint $table) {
            if (!Schema::hasColumn('sliders', 'description')) {
                $table->text('description')->nullable()->after('title');
            }
        });

        if (Schema::hasColumn('sliders', 'link') && !Schema::hasColumn('sliders', 'link_url')) {
            Schema::table('sliders', function (Blueprint $table) {
                $table->renameColumn('link', 'link_url');
            });
        }

        if (Schema::hasColumn('sliders', 'image') && !Schema::hasColumn('sliders', 'image_path')) {
            Schema::table('sliders', function (Blueprint $table) {
                $table->renameColumn('image', 'image_path');
            });
        }

        // ── Galleries: add cover_image and published_at ──
        Schema::table('galleries', function (Blueprint $table) {
            if (!Schema::hasColumn('galleries', 'cover_image')) {
                $table->string('cover_image')->nullable()->after('title');
            }
            if (!Schema::hasColumn('galleries', 'published_at')) {
                $table->timestamp('published_at')->nullable()->after('description');
            }
        });
    }

    public function down(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            if (Schema::hasColumn('sliders', 'description')) {
                $table->dropColumn('description');
            }
        });

        if (Schema::hasColumn('sliders', 'link_url') && !Schema::hasColumn('sliders', 'link')) {
            Schema::table('sliders', function (Blueprint $table) {
                $table->renameColumn('link_url', 'link');
            });
        }

        if (Schema::hasColumn('sliders', 'image_path') && !Schema::hasColumn('sliders', 'image')) {
            Schema::table('sliders', function (Blueprint $table) {
                $table->renameColumn('image_path', 'image');
            });
        }

        Schema::table('galleries', function (Blueprint $table) {
            if (Schema::hasColumn('galleries', 'cover_image')) {
                $table->dropColumn('cover_image');
            }
            if (Schema::hasColumn('galleries', 'published_at')) {
                $table->dropColumn('published_at');
            }
        });
    }
};
