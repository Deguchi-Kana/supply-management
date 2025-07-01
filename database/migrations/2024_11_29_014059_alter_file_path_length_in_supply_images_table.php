<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterFilePathLengthInSupplyImagesTable extends Migration
{
    public function up()
    {
        Schema::table('supply_images', function (Blueprint $table) {
            $table->string('file_path', 500)->change();
        });
    }

    public function down()
    {
        //
    }
}
