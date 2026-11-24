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
        Schema::table('learning_locations', function (Blueprint $table): void {
            $table->unsignedInteger('capacity')->nullable()->after('facilities');
            $table->string('contact_info')->nullable()->after('capacity');
            $table->string('age_group')->nullable()->after('contact_info');
            $table->text('access_notes')->nullable()->after('age_group');
        });

        Schema::create('flags', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->text('description');
            $table->foreignUuid('reporter_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('reporter_name')->nullable();
            $table->foreignUuid('learning_location_id')->nullable()->constrained('learning_locations')->cascadeOnDelete();
            $table->string('place_slug')->index();
            $table->string('moderation_status')->default('Menunggu')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flags');

        Schema::table('learning_locations', function (Blueprint $table): void {
            $table->dropColumn([
                'capacity',
                'contact_info',
                'age_group',
                'access_notes',
            ]);
        });
    }
};
