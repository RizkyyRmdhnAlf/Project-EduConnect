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
        Schema::create('learning_locations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('owner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category')->index();
            $table->text('description');
            $table->string('location')->index();
            $table->string('city')->nullable()->index();
            $table->text('public_address');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->text('cost_info');
            $table->boolean('is_free')->default(true);
            $table->text('schedule')->nullable();
            $table->boolean('weekend_availability')->default(false);
            $table->text('facilities')->nullable();
            $table->string('image')->nullable();
            $table->string('publication_status')->default('Menunggu')->index();
            $table->timestamps();
        });

        Schema::create('learning_needs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('reporter_id')->constrained('users')->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->string('category')->index();
            $table->text('description');
            $table->string('area_label')->index();
            $table->string('need_status')->default('Diajukan')->index();
            $table->timestamps();
        });

        Schema::create('assistance_offers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('need_id')->constrained('learning_needs')->cascadeOnDelete();
            $table->foreignUuid('volunteer_id')->constrained('users')->cascadeOnDelete();
            $table->text('offer_description');
            $table->string('offer_status')->default('Diajukan')->index();
            $table->timestamps();
        });

        Schema::create('verifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('target_type')->index();
            $table->uuid('target_id')->index();
            $table->foreignUuid('admin_id')->constrained('users')->cascadeOnDelete();
            $table->string('decision')->index();
            $table->text('reason')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('actor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action')->index();
            $table->string('target_type')->index();
            $table->uuid('target_id')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('verifications');
        Schema::dropIfExists('assistance_offers');
        Schema::dropIfExists('learning_needs');
        Schema::dropIfExists('learning_locations');
    }
};
