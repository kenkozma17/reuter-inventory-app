<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->nullable();
            $table->string('slug', 75)->nullable();
            $table->double('quantity')->nullable();
            $table->string('size', 75)->nullable();
            $table->string('color', 50)->nullable();
            $table->double('price')->nullable();
            $table->boolean('has_notification')->default(0)->nullable();
            $table->double('notification_quantity')->nullable();
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
        Schema::dropIfExists('products');
    }
}
