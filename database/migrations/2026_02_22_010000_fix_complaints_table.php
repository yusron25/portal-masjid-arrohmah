<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            // Rename existing columns
            if (Schema::hasColumn('complaints', 'name') && !Schema::hasColumn('complaints', 'citizen_name')) {
                $table->renameColumn('name', 'citizen_name');
            }
            if (Schema::hasColumn('complaints', 'image') && !Schema::hasColumn('complaints', 'evidence_image')) {
                $table->renameColumn('image', 'evidence_image');
            }
        });

        Schema::table('complaints', function (Blueprint $table) {
            // Add missing columns
            if (!Schema::hasColumn('complaints', 'citizen_nik')) {
                $table->string('citizen_nik', 32)->nullable()->after('citizen_name');
            }
            if (!Schema::hasColumn('complaints', 'citizen_phone')) {
                $table->string('citizen_phone', 32)->nullable()->after('citizen_nik');
            }
            if (!Schema::hasColumn('complaints', 'category_id')) {
                $table->foreignId('category_id')->nullable()->after('citizen_phone')->constrained()->nullOnDelete();
            }
            if (!Schema::hasColumn('complaints', 'location')) {
                $table->string('location', 255)->nullable()->after('description');
            }
        });
    }

    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
            $table->dropColumn(['citizen_nik', 'citizen_phone', 'location']);
        });

        Schema::table('complaints', function (Blueprint $table) {
            $table->renameColumn('citizen_name', 'name');
            $table->renameColumn('evidence_image', 'image');
        });
    }
};
