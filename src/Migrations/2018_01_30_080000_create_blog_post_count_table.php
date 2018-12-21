<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBlogPostCountTable extends Migration
{
    protected $table='blog_post_count';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable($this->table)) {
            Schema::create($this->table, function (Blueprint $table) {
                $table->increments('id');
                $table->integer('post_id')->index();
                $table->string('relationship', 50)->index();
                $table->string('type', 50)->index();
                $table->integer('q');
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('deleted_by')->nullable();
                $table->string('deleted_ip')->nullable();
                $table->string('created_ip')->nullable();
                $table->string('updated_ip')->nullable();
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
        Schema::drop($this->table);
    }
}
