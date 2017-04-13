<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id', false, true);
            $table->string('email')->unique();
            $table->string('full_name');
            $table->string('phone', 30);
            $table->date('dob');
            $table->string('sex', 30);
            $table->boolean('verified')->default(false);
            $table->string('status', 30)->nullable();
            $table->dateTime('last_login')->nullable();
            $table->string('pin');
            $table->double('balance', 15, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_accounts');
    }
}
