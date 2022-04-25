<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained();
            $table->string('paper');
            $table->foreignId('finish_id')->constrained();
            $table->string('border');
            $table->string('format');
            $table->double('total_price', 8, 2);
            $table->integer('total_photos');
            $table->enum('status', ['received', 'progress', 'delivered'])->default('received');
            $table->boolean('paid')->default(false);
            $table->foreignId('client_id')->constrained();
            $table->string('stripe_reference');
            $table->foreignId('client_card_id')->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
