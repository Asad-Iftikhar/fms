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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string( 'username', 30 )->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean( 'require_pw_change' )->default( 0 );
            $table->string( 'reminder_code', 60 )->nullable();
            $table->string( 'activation_code', 60 )->nullable();
            $table->text( 'first_name' )->nullable();
            $table->text( 'last_name' )->nullable();
            $table->text( 'phone' )->nullable();
            $table->integer( 'avatar' )->unsigned()->nullable()->index();
            $table->dateTime( 'last_login' )->nullable()->index();
            $table->boolean( 'activated' )->default( 0 );
            $table->boolean( 'disabled' )->default( 0 );
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
