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
            $table->longText('device')->nullable();
            $table->longText('operating')->nullable();
            $table->longText('browser')->nullable();
            $table->longText('browser_version')->nullable();
            $table->longText('time_zone')->nullable();
            $table->longText('asn')->nullable();
            $table->longText('asn_org')->nullable();
            $table->longText('view_at')->nullable();
            $table->longText('date_at')->nullable();
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
