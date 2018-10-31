<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogPostContents extends Migration
{
    protected $table='blog_post_contents';
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
                $table->string('content_type');
                $table->string('content_source')->nullable();
                $table->text('content');
                $table->integer('x');
                $table->integer('y');
                $table->integer('width');
                $table->integer('height');
                $table->integer('post_id');
                $table->timestamps();
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
        Schema::dropIfExist($this->table);
    }
}
