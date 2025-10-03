<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('tags')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->foreignId('category_id')->constrained('productcategories')->onDelete('cascade');
            $table->boolean('has_variations')->default(false);
            $table->string('measurement_unit')->nullable(); // kg, g, L, ml, pcs
            $table->decimal('price_kes', 10, 2)->nullable();
            $table->decimal('price_usd', 10, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->timestamps();
        });

        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('name'); // e.g., "1", "2", "5" (quantity)
            $table->string('display_name'); // e.g., "1kg", "2L", "500g"
            $table->string('sku')->nullable()->unique();
            $table->decimal('price_kes', 10, 2);
            $table->decimal('price_usd', 10, 2);
            $table->integer('stock')->default(0);
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('variation_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Size", "Weight", "Color"
            $table->timestamps();
        });

        Schema::create('variation_attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attribute_id')->constrained('variation_attributes')->onDelete('cascade');
            $table->string('value'); // e.g., "2L", "5kg", "Red"
            $table->timestamps();
        });

        Schema::create('product_variation_attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variant_id')->constrained('product_variants')->onDelete('cascade');
            $table->foreignId('attribute_value_id')->constrained('variation_attribute_values')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variation_attribute_values');
        Schema::dropIfExists('variation_attribute_values');
        Schema::dropIfExists('variation_attributes');
        Schema::dropIfExists('product_variants');
        Schema::dropIfExists('products');
    }
};
