<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogPostRelatedTable extends Migration
{
    protected $table='blog_post_related';

    public function up()
    {
        if (!Schema::hasTable($this->table)) {
            Schema::create($this->table, function (Blueprint $table) {
                $table->increments('id');
                $table->integer('post_id')->nullable();
                $table->integer('related_id')->nullable();
                $table->integer('pos')->nullable();
                $table->string('type', 50)->nullable();
                $table->string('note')->nullable();
                $table->integer('sons_count')->nullable();
                $table->integer('parents_count')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
