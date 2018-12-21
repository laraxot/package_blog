<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogPostRecipesTable extends Migration
{
    protected $table='blog_post_recipes';

    public function up()
    {
        if (!Schema::hasTable($this->table)) {
            Schema::create($this->table, function (Blueprint $table) {
                //$table->increments('id');
                $table->integer('post_id')->index();
                
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('deleted_by')->nullable();

                $table->ipAddress('created_ip')->nullable();
                $table->ipAddress('updated_ip')->nullable();
                $table->ipAddress('deleted_ip')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
