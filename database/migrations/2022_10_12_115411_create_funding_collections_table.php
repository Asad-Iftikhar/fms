<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Users\User;
use App\Models\Fundings\FundingType;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funding_collections', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('CASCADE');
            $table->foreignId('funding_type_id')->nullable()->constrained()->onDelete('CASCADE');
            $table->float( 'amount' )->nullable();
            $table->foreignId('event_id')->nullable()->constrained('events')->onDelete('CASCADE');
            $table->boolean( 'is_received' )->default( 0 );
            $table->boolean( 'is_invited' )->default( 0 );
            $table->boolean( 'is_reminded' )->default( 0 );
            $table->dateTime( 'last_reminded' )->nullable();
            $table->dateTime( 'last_invited' )->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
