<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->unsignedInteger('host_id')->nullable();
            $table->string('host_name')->nullable();
            $table->string('neighbourhood_group')->nullable();
            $table->string('neighbourhood')->nullable();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->string('room_type')->nullable();
            $table->unsignedInteger('price')->nullable();
            $table->unsignedInteger('minimum_nights')->nullable();
            $table->unsignedInteger('number_of_reviews')->nullable();
            $table->date('last_review')->nullable();
            $table->double('reviews_per_month')->nullable();
            $table->unsignedInteger('host_listings_count')->nullable();
            $table->unsignedInteger('availability')->nullable();
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
        Schema::dropIfExists('listings');
    }
}
