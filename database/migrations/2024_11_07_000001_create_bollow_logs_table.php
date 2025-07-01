<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBollowLogsTable extends Migration
{
    public function up()
    {
        Schema::create('bollow_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supply_id')->constrained('supplies');
            $table->foreignId('user_id')->constrained('users');
            $table->date('borrow_date');
            $table->date('return_date')->nullable();
            $table->string('status', 50);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bollow_logs');
    }
}
