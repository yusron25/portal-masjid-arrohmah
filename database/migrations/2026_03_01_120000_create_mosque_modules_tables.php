<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Jadwal Kajian & Dakwah
        Schema::create('kajian_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('speaker');
            $table->string('day_of_week')->nullable();
            $table->time('time_start');
            $table->time('time_end')->nullable();
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_recurring')->default(true);
            $table->date('event_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Keuangan / Finance
        Schema::create('finances', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // income, expense
            $table->string('fund_source'); // kas_dkm, gias
            $table->decimal('amount', 15, 2);
            $table->string('description');
            $table->date('transaction_date');
            $table->string('receipt_image')->nullable();
            $table->timestamps();
        });

        // Program Sosial & Pendidikan
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('category'); // sosial, pendidikan
            $table->boolean('is_active')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        // Pengumuman & Agenda
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('type'); // pengumuman, agenda
            $table->datetime('event_date')->nullable();
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        // Media Sosial
        Schema::create('social_media', function (Blueprint $table) {
            $table->id();
            $table->string('platform');
            $table->string('url');
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_media');
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('programs');
        Schema::dropIfExists('finances');
        Schema::dropIfExists('kajian_schedules');
    }
};
