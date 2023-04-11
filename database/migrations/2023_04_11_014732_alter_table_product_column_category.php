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
        if (!Schema::hasColumns('products', ['description',"category_id"]))
        {
            Schema::table('products', function (Blueprint $table)
            {
                $table->text("description");
                $table->bigInteger("category_id");
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
        if (Schema::hasColumns('products', ['description',"category_id"]))
        {
            Schema::table('products', function (Blueprint $table)
            {
                $table->dropColumn('description');
                $table->dropColumn('category_id');
            });
        }
    }
};
