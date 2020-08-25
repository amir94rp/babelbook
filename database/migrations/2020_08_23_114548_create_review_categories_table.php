<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('is_parent')->default(0);
            $table->tinyInteger('has_parent')->default(0);
            $table->integer('parent_id')->nullable();
            $table->integer('image_id')->nullable();
            $table->string('name');
            $table->string('url_en_name');
            $table->tinyInteger('deleted')->default(0);
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
        Schema::dropIfExists('review_categories');
    }
}
