<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->foreignId('owner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('location')->index();
            $table->string('city')->nullable()->index();
            $table->string('address');
            $table->string('category')->index();
            $table->string('image')->nullable();
            $table->string('cost')->default('Gratis');
            $table->boolean('is_free')->default(true);
            $table->string('schedule')->nullable();
            $table->boolean('weekend_availability')->default(false);
            $table->json('facilities')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('verification_status')->default('Menunggu')->index();
            $table->timestamps();
        });

        Schema::create('needs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('location')->index();
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
            $table->string('category')->index();
            $table->string('status')->default('Diajukan')->index();
            $table->timestamps();
        });

        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('volunteer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('need_id')->constrained('needs')->cascadeOnDelete();
            $table->string('status')->default('Diajukan')->index();
            $table->timestamps();
        });

        Schema::create('flags', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('reporter_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('place_id')->constrained('places')->cascadeOnDelete();
            $table->string('moderation_status')->default('Menunggu')->index();
            $table->timestamps();
        });

        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('entity')->index();
            $table->unsignedBigInteger('record_id')->index();
            $table->foreignId('owner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('actor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('previous_status')->nullable();
            $table->string('new_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('flags');
        Schema::dropIfExists('offers');
        Schema::dropIfExists('needs');
        Schema::dropIfExists('places');
    }
};
