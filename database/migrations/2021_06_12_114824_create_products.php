<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
USE Illuminate\Support\Facades\DB;

class CreateProducts extends Migration
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
            $table->string('name');
            $table->integer('available_stock');
            $table->timestamps();
        });

        DB::unprepared("INSERT INTO `products` (`name`, `available_stock`) values('Mcdonalds French Fries(large)', 2), ('Mcdonalds French Fries(medium)', 2),('Mcdonalds French Fries(small)', 2),
        ('Mcdonalds cheese burger meal(large)', 2), ('Mcdonalds cheese burger meal(medium)', 2), ('Mcdonalds cheese burger meal(small)', 2);");
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
