<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {

            $table->ulid('id')->primary();


            $table->string('title');
            $table->text('description');

            $table->decimal('price', 8, 2);

            $table->foreignUlid('instructor_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
