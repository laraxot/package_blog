<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogPostArticlesTable extends Migration{
    protected $table='blog_post_articles';

    public function up(){
        if (!Schema::hasTable($this->table)) {
            Schema::create($this->table, function (Blueprint $table) {
                //$table->increments('id');
                $table->integer('post_id');
                $table->index('post_id');
                $table->string('article_type',50)->nullable();
                $table->datetime('published_at')->nullable();
                $table->timestamps();
            });
        }  
    }

    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
