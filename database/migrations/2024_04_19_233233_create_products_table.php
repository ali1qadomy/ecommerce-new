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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->String("name_en")->uniqid();
            $table->String("name_ar")->uniqid();
            $table->text('description_en');
            $table->text('description_ar');
            $table->string('image_url');
            $table->unsignedBigInteger('category_id');
            $table->boolean('active')->default(true);
            $table->foreign('category_id')->references('id')->on('category')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
