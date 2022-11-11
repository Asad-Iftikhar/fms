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
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('collection_id');
            $table->unsignedInteger('from_user');
            $table->text('content')->nullable();
            $table->foreignId('image_id')->nullable();
            $table->boolean('is_read');
            $table->timestamps();
        });
    }
};
