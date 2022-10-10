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
            $table->increments('id');
            $table->integer('employee_id')->unique()->nullable();
            $table->string( 'username', 30 )->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string( 'locale', 10 )->default( 'en' )->index();
            $table->boolean( 'require_pw_change' )->default( 0 );
            $table->string( 'reminder_code', 60 )->nullable();
            $table->string( 'reset_token', 60 )->nullable();
            $table->string( 'activation_code', 60 )->nullable();
            $table->text( 'first_name' )->nullable();
            $table->text( 'last_name' )->nullable();
            $table->text( 'phone' )->nullable();
            $table->enum( 'gender', ['male', 'female'])->nullable();
            $table->integer( 'avatar' )->unsigned()->nullable();
            $table->date( 'joining_date' )->nullable();
            $table->date( 'dob' )->nullable();
            $table->dateTime( 'last_login' )->nullable()->index();
            $table->boolean( 'activated' )->default( 0 );
            $table->boolean( 'disabled' )->default( 0 );
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create( 'roles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments( 'id' );
            $table->string( 'name', 100 )->index();
            $table->string( 'description' )->nullable();
            $table->integer( 'level' );
            $table->timestamps();
            $table->softDeletes();
        } );

        Schema::create( 'role_user', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger( 'user_id' )->index();
            $table->unsignedInteger( 'role_id' )->index();
            $table->timestamps();
        } );


        Schema::table('role_user', function(Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('CASCADE');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
        });

        Schema::create( 'permission_role', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer( 'permission_id' )->unsigned()->index();
            $table->integer( 'role_id' )->unsigned()->index();
            $table->timestamps();
        } );

        Schema::create( 'permissions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments( 'id' );
            $table->string( 'name', 100 )->index();
            $table->string( 'description' )->nullable();
            $table->timestamps();
        } );

        Schema::create( 'menus', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments( 'id' );
            $table->integer( 'parent_id' )->default( 0 )->index();
            $table->text( 'title' );
            $table->text( 'url' );
            $table->integer( 'position' )->default( 0 );
            $table->integer( 'menu_group_id' )->unsigned()->default( 1 )->index();
        } );

        Schema::create( 'menu_groups', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments( 'id' );
            $table->text( 'title' );
            $table->text( 'slug' );
        } );

        Schema::create( 'menu_user_groups', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer( 'menu_id' )->unsigned()->index();
            $table->integer( 'group_id' )->unsigned()->index();
            $table->timestamps();
        } );

        Schema::create( 'menu_user_permissions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer( 'menu_id' )->unsigned()->index();
            $table->integer( 'permission_id' )->unsigned()->index();
            $table->timestamps();
        } );

        Schema::table('menu_user_permissions', function(Blueprint $table) {
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('CASCADE');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('CASCADE');
        });

        // Add Foreign
        Schema::table('permission_role', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('CASCADE');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // To Drop Data we will write separate migrations
    }
};
