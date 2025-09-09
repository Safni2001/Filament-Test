<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('type_assignments', function (Blueprint $table) {
            $table->id();
            $table->integer('type_assignable_id');
            $table->string('type_assignable_type', 65);
            $table->foreignId('product_type_id')->nullable()->constrained()->onDelete('set null');
            $table->string('my_bonus_field', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_assignments');
    }
};