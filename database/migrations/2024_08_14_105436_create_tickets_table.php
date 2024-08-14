<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->unsignedBigInteger('siswa_id'); // Siswa who created the ticket
            $table->unsignedBigInteger('guru_id')->nullable(); // Guru who receives the ticket
            $table->timestamp('scheduled_at')->nullable(); // Scheduled time
            $table->enum('status', ['pending', 'scheduled', 'closed'])->default('pending');
            $table->timestamps();

            // Foreign keys
            $table->foreign('siswa_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('guru_id')->references('id')->on('users')->onDelete('set null');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
