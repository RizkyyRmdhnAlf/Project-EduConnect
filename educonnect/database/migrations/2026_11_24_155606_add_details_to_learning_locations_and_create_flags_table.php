<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pulihkan tabel jika belum tersedia di database.
        if (! Schema::hasTable('learning_locations')) {
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
        }

        // Tambahkan informasi tambahan.
        Schema::table('learning_locations', function (Blueprint $table): void {
            $table->unsignedInteger('capacity')->nullable()->after('facilities');
            $table->string('contact_info')->nullable()->after('capacity');
            $table->string('age_group')->nullable()->after('contact_info');
            $table->text('access_notes')->nullable()->after('age_group');
        });

        // Buat tabel laporan lokasi.
        if (! Schema::hasTable('flags')) {
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
    }

    public function down(): void
    {
        Schema::dropIfExists('flags');

        if (Schema::hasTable('learning_locations')) {
            Schema::table('learning_locations', function (Blueprint $table): void {
                $table->dropColumn([
                    'capacity',
                    'contact_info',
                    'age_group',
                    'access_notes',
                ]);
            });
        }
    }
};
