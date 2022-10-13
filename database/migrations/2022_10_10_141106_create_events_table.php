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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('created_by');
            $table->date('event_date')->nullable();
            $table->integer('event_cost')->nullable();
            $table->integer('cash_by_funds')->nullable();
            $table->integer('cash_by_collections')->nullable();
            $table->enum('payment_mode',[1,2])->default(1);
            $table->enum('status',['draft','active','finished'])->default('draft');
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

    }
};
