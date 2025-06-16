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
        Schema::create('gift_certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_type_id')->constrained();
            $table->string('name')->unique();
            $table->string('description');
            $table->double('price');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('status')->default(0)->comment('0 = active, 1 = inactive');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_certificates');
    }
};
