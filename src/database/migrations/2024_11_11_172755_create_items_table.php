<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('img_url');
            $table->string('brand')->nullable();
            $table->integer('price');
            $table->string('color')->nullable();
            $table->text('description');
            $table->string('category');
            $table->string('condition');
            $table->string('comment')->nullable();
            $table->integer('comments_count')->default(0);
            $table->enum('status',['available','soldout'])->default('available');
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
        Schema::dropIfExists('items');
    }
}