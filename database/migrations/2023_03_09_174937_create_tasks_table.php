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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string("description");
            $table->string("title")->unique();
            $table->boolean("visible_to_all");
            $table->string("status");
            $table->string("complete_until")->nullable();
            $table->integer("completed_by")->nullable();
            $table->string("completed_in")->nullable();
            $table->string("assigned_to")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
