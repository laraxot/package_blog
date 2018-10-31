<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToBlogPostShopItems extends Migration{
    protected $table='blog_post_shop_items';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::table($this->table, function (Blueprint $table) {
            if (!Schema::hasColumn($this->table, 'num')) {
                $table->integer('num')->nullable();
            }
            if (!Schema::hasColumn($this->table, 'created_by')) {
                $table->string('created_by')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->dropColumn(['num']);
        });
    }
}
