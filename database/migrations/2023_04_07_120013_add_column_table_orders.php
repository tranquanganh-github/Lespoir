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

        if (!Schema::hasColumns('orders', ['name',"email","message"]))
        {
            Schema::table('orders', function (Blueprint $table)
            {
                $table->string("name");
                $table->string("email");
                $table->text("message");
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumns('orders', ['name',"email","message"]))
        {
            Schema::table('orders', function (Blueprint $table)
            {
                $table->dropColumn('name');
                $table->dropColumn('email');
                $table->dropColumn('message');
            });
        }
    }
};
