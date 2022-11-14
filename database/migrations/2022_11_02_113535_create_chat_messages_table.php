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
        Schema::create('funding_collection_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('collection_id')->nullable()->constrained('funding_collections')->onDelete('CASCADE');
            $table->foreignId('from_user');
            $table->text('content')->nullable();
            $table->foreignId('image_id')->nullable()->constrained('media')->onDelete('CASCADE');;
            $table->boolean('is_read')->default(0);
            $table->timestamps();
        });
    }
};
