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
        Schema::create('realms', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('auth_database_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->unsignedBigInteger('realmlist_id')->unique();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->integer('priority')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('realms');
    }
};
