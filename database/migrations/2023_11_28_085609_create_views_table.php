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
        Schema::create('views', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('post_id');
            $table->longText('user_ip');
            $table->longText('method');
            $table->longText('host');
            $table->longText('url');
            $table->longText('referer')->nullable();
            $table->longText('country')->nullable();
            $table->longText('device');
            $table->longText('operating');
            $table->longText('browser');
            $table->longText('browser_version');
            $table->longText('time_zone');
            $table->longText('asn');
            $table->longText('asn_org');
            $table->longText('view_at');
            $table->longText('date_at');
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
        Schema::dropIfExists('views');
    }
};
