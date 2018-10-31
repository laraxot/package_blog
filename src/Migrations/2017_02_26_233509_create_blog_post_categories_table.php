<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogPostCategoriesTable extends Migration{
    protected $table='blog_post_categories';

    public function up(){
        if (!Schema::hasTable($this->table)) {
            Schema::create($this->table, function (Blueprint $table) {
                $table->integer('post_id');
                $table->index('post_id');
                $table->timestamps();
            });
        }
    }

    public function down(){
        Schema::dropIfExists($this->table);
    }
}
