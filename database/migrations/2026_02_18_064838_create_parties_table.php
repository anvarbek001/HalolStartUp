<?php

use App\Enums\PartyStatus;
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
        Schema::create('parties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('brand_id')->constrained('brands')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('name');
            $table->string('rating')->nullable();
            $table->text('description');
            $table->bigInteger('order');
            $table->string('image');
            $table->string('status')->default(PartyStatus::INACTIVE->value);
            $table->string('payment_status')->default('unpaid');
            $table->integer('product_count')->default(0);
            $table->bigInteger('uniq_id')->nullable();
            $table->dateTime('manufactured_at')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->integer('price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parties');
    }
};
