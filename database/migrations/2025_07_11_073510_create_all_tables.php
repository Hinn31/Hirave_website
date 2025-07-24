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
        // Users
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // dùng id mặc định (khuyên dùng)
            $table->string('fullname', 50);
            $table->date('date_of_birth')->nullable();
            $table->string('phone', 10)->nullable();
            $table->string('email', 100)->unique();
            $table->string('username', 50)->unique();
            $table->string('password', 100);
            $table->string('avatar', 135)->nullable();
            $table->enum('role', ['admin', 'customer'])->default('customer');
            $table->timestamps();
        });

        // Categories
            Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('categoryName', 100)->unique();
            $table->string('image', 255)->nullable(); // đặt sau categoryName
            $table->timestamps();
        });


        // Products
       Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('productName', 100);
        $table->decimal('price', 12, 2);
        $table->decimal('oldPrice', 12, 2)->nullable();
        $table->text('description')->nullable();
        $table->string('imageURL', 255)->nullable();
        $table->integer('stock')->default(0);
        $table->foreignId('categoryID')->constrained('categories')->onDelete('cascade');
        $table->boolean('is_best_seller')->default(false);
        $table->boolean('is_new_product')->default(false);
        $table->timestamps();
     });

        // Carts
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->dateTime('createDate')->useCurrent();
            $table->enum('status', ['pending', 'completed'])->default('pending');
            $table->foreignId('userID')->constrained('users')->onDelete('cascade');
        });

        // Cart Items
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->foreignId('cartID')->constrained('carts')->onDelete('cascade');
            $table->foreignId('productID')->constrained('products')->onDelete('cascade');
        });

        // Orders
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->dateTime('orderDate')->useCurrent();
            $table->enum('status', ['pending', 'shipped', 'delivered', 'cancelled'])->default('pending');
            $table->text('description')->nullable();
            $table->decimal('totalAmount', 12, 2);
            $table->foreignId('userID')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        // Order Details
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->decimal('price', 12, 2);
            $table->foreignId('orderID')->constrained('orders')->onDelete('cascade');
            $table->foreignId('productID')->constrained('products')->onDelete('cascade');
        });

        // Payments
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('method')->nullable();
            $table->enum('status', ['pending', 'paid', 'failed'])->default('pending');
            $table->dateTime('paymentDate')->useCurrent();
            $table->foreignId('orderID')->constrained('orders')->onDelete('cascade');
        });

        // Notifications
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('message');
            $table->dateTime('sendDate')->useCurrent();
            $table->enum('status', ['unread', 'read'])->default('unread');
            $table->foreignId('userID')->constrained('users')->onDelete('cascade');
        });

        // Reviews
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->integer('rating');
            $table->text('comment')->nullable();
            $table->dateTime('reviewDate')->useCurrent();
            $table->foreignId('userID')->constrained('users')->onDelete('cascade');
            $table->foreignId('productID')->constrained('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('order_details');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('carts');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('users');
    }
};
