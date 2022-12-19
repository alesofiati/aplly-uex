<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->string("name", 60);
            $table->string("document_number", 11);
            $table->string("phone_number", 11);
            $table->string("street");
            $table->string("street_number");
            $table->string("neighborhood");
            $table->string("city");
            $table->string("state");
            $table->string("complement")->nullable();
            $table->string("latitude")->nullable();
            $table->string("longitude")->nullable();
            $table->foreign("user_id")->references("id")->on("users")->cascadeOnDelete();
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
        Schema::dropIfExists('user_contacts');
    }
};
