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
        // ========== WORKERS ==========
        Schema::create('tailors', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('phone_number', 15)->nullable();
            $table->text('address')->nullable();
            $table->decimal('rate_per_piece', 10, 2)->default(0);
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            $table->timestamps();
        });

        Schema::create('couriers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('phone_number', 15)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Added: cutters (pemotong) + coordinates
        Schema::create('cutters', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('phone_number', 15)->nullable();
            $table->text('address')->nullable();
            $table->decimal('rate_per_piece', 10, 2)->default(0);
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            $table->timestamps();
        });

        // Added: overdecks (overdek)
        Schema::create('overdecks', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('phone_number', 15)->nullable();
            $table->decimal('rate_per_piece', 10, 2)->default(0);
            $table->timestamps();
        });

        // Added: obras
        Schema::create('obras', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('phone_number', 15)->nullable();
            $table->text('address')->nullable();
            $table->decimal('rate_per_piece', 10, 2)->default(0);
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            $table->timestamps();
        });

        // ========== PRODUCTS ==========
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_name', 100);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('product_name', 100);
            $table->integer('stock')->default(0);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('product_categories')->onDelete('cascade');
        });

        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('size', 10);
            $table->integer('stock')->default(0);
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

        // ========== OPERATIONS ==========
        Schema::create('delivery_to_tailors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('courier_id');
            $table->unsignedBigInteger('tailor_id');
            $table->dateTime('delivery_date');
            $table->date('due_date')->nullable(); // tanggal jatuh tempo
            $table->decimal('material_weight', 5, 2)->nullable(); // total kain
            $table->decimal('remaining', 5, 2)->default(0); // sisa kain (kg)
            $table->float('pickup_weight')->nullable();
            $table->dateTime('pickup_date')->nullable();
            $table->enum('status', ['delivery', 'pickup', 'done', 'partial', 'selesai'])->default('delivery');



            $table->timestamps();

            // relasi
            $table->foreign('courier_id')
                ->references('id')
                ->on('couriers')
                ->onDelete('cascade');

            $table->foreign('tailor_id')
                ->references('id')
                ->on('tailors')
                ->onDelete('cascade');
        });

        Schema::create('delivery_to_obras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('courier_id');
            $table->unsignedBigInteger('obras_id');
            $table->dateTime('delivery_date');
            $table->date('due_date')->nullable(); // tanggal jatuh tempo
            $table->decimal('material_weight', 5, 2)->nullable(); // total kain
            $table->decimal('remaining', 5, 2)->default(0); // sisa kain (kg)
            $table->string('status', 20)->default('pending'); // pending, delivered, in progress, etc.
            $table->timestamps();

            // relasi
            $table->foreign('courier_id')
                ->references('id')
                ->on('couriers')
                ->onDelete('cascade');

            $table->foreign('obras_id')
                ->references('id')
                ->on('obras')
                ->onDelete('cascade');
        });

        Schema::create('delivery_to_cutters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('courier_id');
            $table->unsignedBigInteger('cutter_id');
            $table->dateTime('delivery_date');
            $table->date('due_date')->nullable(); // tanggal jatuh tempo
            $table->decimal('material_weight', 5, 2)->nullable(); // total kain
            $table->decimal('remaining', 5, 2)->default(0); // sisa kain (kg)
            $table->string('status', 20)->default('pending'); // pending, delivered, in progress, etc.
            $table->timestamps();

            // relasi
            $table->foreign('courier_id')
                ->references('id')
                ->on('couriers')
                ->onDelete('cascade');

            $table->foreign('cutter_id')
                ->references('id')
                ->on('cutters')
                ->onDelete('cascade');
        });


        Schema::create('clothes_in_warehouse', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('obras_id');
            $table->dateTime('date_in');
            $table->integer('quantity');
            $table->string('clothing_type', 50);
            $table->string('size', 10)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('obras_id')->references('id')->on('obras')->onDelete('cascade');
        });

        Schema::create('clothes_out_warehouse', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_out');
            $table->unsignedBigInteger('product_variant_id');
            $table->integer('quantity_out');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('product_variant_id')->references('id')->on('product_variants')->onDelete('cascade');
        });

        // ========== REPORTS ==========
        Schema::create('tailor_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tailor_id');
            $table->date('period');
            $table->integer('total_sewn')->default(0);
            $table->decimal('total_payment', 10, 2)->default(0);
            $table->timestamps();

            $table->foreign('tailor_id')->references('id')->on('tailors')->onDelete('cascade');
        });

        Schema::create('sales_reports', function (Blueprint $table) {
            $table->id();
            $table->date('period');
            $table->integer('total_sold')->default(0);
            $table->decimal('total_income', 10, 2)->default(0);
            $table->timestamps();
        });

        // ========== CONVECTION & TRACKING ==========
        Schema::create('convection_locations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('address')->nullable();
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            $table->timestamps();
        });

        Schema::create('courier_tracking', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('courier_id');
            $table->unsignedBigInteger('convection_id');
            $table->dateTime('timestamp');
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            $table->enum('status', ['mengantar', 'proses', 'mengambil', 'selesai']);
            $table->timestamps();

            $table->foreign('courier_id')->references('id')->on('couriers')->onDelete('cascade');
            $table->foreign('convection_id')->references('id')->on('convection_locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::dropIfExists('courier_tracking');
    Schema::dropIfExists('delivery_to_cutters');
    Schema::dropIfExists('delivery_to_obras');
    Schema::dropIfExists('delivery_to_tailors');
    Schema::dropIfExists('clothes_out_warehouse');
    Schema::dropIfExists('clothes_in_warehouse');
    Schema::dropIfExists('tailor_reports');
    Schema::dropIfExists('sales_reports');
    Schema::dropIfExists('product_variants');
    Schema::dropIfExists('products');
    Schema::dropIfExists('product_categories');
    Schema::dropIfExists('couriers'); // Sekarang aman
    Schema::dropIfExists('tailors');
    Schema::dropIfExists('obras');
    Schema::dropIfExists('overdecks');
    Schema::dropIfExists('cutters');
    Schema::dropIfExists('convection_locations');

    Schema::enableForeignKeyConstraints();

}

};
