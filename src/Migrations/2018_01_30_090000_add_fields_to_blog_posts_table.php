<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToBlogPostsTable extends Migration
{
    protected $table='blog_posts';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table, function (Blueprint $table) {
            if (!Schema::hasColumn($this->table, 'guid')) {
                $table->string('guid')->nullable();
            }
            if (!Schema::hasColumn($this->table, 'category_id')) {
                $table->integer('category_id')->nullable();
            }
            if (!Schema::hasColumn($this->table, 'author_id')) {
                $table->integer('author_id')->nullable();
            }
            if (!Schema::hasColumn($this->table, 'subtitle')) {
                $table->string('subtitle')->nullable();
            }
            if (!Schema::hasColumn($this->table, 'image')) {
                $table->string('image')->nullable();
            }
            if (!Schema::hasColumn($this->table, 'image_alt')) {
                $table->string('image_alt')->nullable();
            }
            if (!Schema::hasColumn($this->table, 'image_title')) {
                $table->string('image_title')->nullable();
            }
            if (!Schema::hasColumn($this->table, 'meta_description')) {
                $table->text('meta_description')->nullable();
            }
            if (!Schema::hasColumn($this->table, 'meta_keywords')) {
                $table->text('meta_keywords')->nullable();
            }
            if (!Schema::hasColumn($this->table, 'content')) {
                $table->text('content')->nullable();
            }
            if (!Schema::hasColumn($this->table, 'published')) {
                $table->boolean('published')->nullable();
            }
            if (!Schema::hasColumn($this->table, 'created_by')) {
                $table->string('created_by')->nullable();
            }
            if (!Schema::hasColumn($this->table, 'updated_by')) {
                $table->string('updated_by')->nullable();
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
            $table->dropColumn(['guid']);
        });
    }
}
