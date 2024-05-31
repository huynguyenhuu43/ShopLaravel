<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**id, category_id, section_id, 
     * brand_id, vendor_id, admin_type, product_name, product_code, 
     * product_color, main_image, description, product_price, product_discount, 
     * product_weight, product_video, 
     * meta_title, meta_description, meta_keywords, is_featured and status
     * Run the migrations.
     * 
     * up set thuộc tính bảng
     
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('section_id');
            $table->integer('category_id');
            $table->integer('brand_id');
            $table->integer('vendor_id');
            $table->string('admin_type');
            $table->string('product_name');
            $table->string('product_code');
            $table->string('product_color');
            $table->float('product_price');
            $table->float('product_discount');
            $table->integer('product_weight');
            $table->string('product_image');
            $table->string('product_video');
            $table->string('description');
            $table->string('meta_title');
            $table->string('meta_description');
            $table->string('meta_keywords');
            $table->enum('is_featured',['No','Yes']);
            $table->tinyInteger('status');
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
