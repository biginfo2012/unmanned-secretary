<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('role');
            $table->string('user_code')->nullable();
            $table->string('post_code');
            $table->string('address');
            $table->string('contact');
            $table->string('department')->nullable();
            $table->string('represent')->nullable();
            $table->string('charge')->nullable();
            $table->tinyInteger('type')->default(1)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('remarks')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('plan_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
