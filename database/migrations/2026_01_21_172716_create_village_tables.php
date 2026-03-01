<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('thumbnail')->nullable();
            $table->longText('content');
            $table->timestamp('published_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('cover_image')->nullable();
            $table->text('description')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('gallery_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_id')->constrained()->cascadeOnDelete();
            $table->string('image_path');
            $table->timestamps();
        });

        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('image_path');
            $table->text('description')->nullable();
            $table->string('link_url')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_code')->unique();
            $table->string('citizen_name');
            $table->string('citizen_nik');
            $table->string('citizen_phone');
            $table->text('description');
            $table->string('location')->nullable();
            $table->string('evidence_image')->nullable();
            $table->string('status')->default('pending');
            $table->text('admin_response')->nullable();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
        Schema::dropIfExists('sliders');
        Schema::dropIfExists('gallery_images');
        Schema::dropIfExists('galleries');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('categories');
    }
};
