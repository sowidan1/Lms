<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {

            $table->ulid('id')->primary();

            $table->string('stripe_subscription_id');
            $table->string('status');

            $table->foreignUlid('user_id')->references('id')->on('users');
            $table->foreignUlid('course_id')->references('id')->on('courses');

            $table->timestamp('ends_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
