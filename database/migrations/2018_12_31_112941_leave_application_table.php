<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LeaveApplicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('leave_application', function (Blueprint $table) {
          $table->increments('id');
          $table->string('type');
          $table->string('startDate');
          $table->string('endDate');
          $table->string('reliever');
          $table->string('leave_days');
          $table->string('HOD');
          $table->string('HR');
          $table->string('MD');
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
        //
    }
}
