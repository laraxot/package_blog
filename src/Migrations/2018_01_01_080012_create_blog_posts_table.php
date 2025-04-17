<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//--- models --
use XRA\Blog\Models\Post as MyModel;

class CreateBlogPostsTable extends Migration
{
    public function getTable(){
        return with(new MyModel())->getTable();
    }

    public function up(){
        if (!Schema::hasTable($this->getTable())) {
            Schema::create($this->getTable(), function (Blueprint $table) {
                $table->increments('id');
                $table->integer('post_id')->nullable();
                $table->string('lang', 2)->nullable();
                $table->string('title')->index();
                $table->string('subtitle')->nullable();
                $table->string('guid')->nullable();
                $table->string('post_type', 40)->index()->nullable();
                // $table->string('type', 50)->nullable(); //da capire se fare tabella collegata o meno
                $table->text('txt')->nullable();
                $table->string('image_src')->nullable();
                $table->string('image_alt')->nullable();
                $table->string('image_title')->nullable();
                $table->text('meta_description')->nullable();
                $table->text('meta_keywords')->nullable();
                $table->integer('author_id')->nullable();
                $table->timestamps();
            });
        }
        Schema::table($this->getTable(), function (Blueprint $table) {
            // if (!Schema::hasColumn($this->getTable(), 'post_type')) {
            //     $table->string('post_type', 40)->after('type')->index()->nullable();
            // }
            $schema_builder = Schema::getConnection()
                ->getDoctrineSchemaManager()
                ->listTableDetails($table->getTable());

            if (!$schema_builder->hasIndex($this->getTable().'_'.'guid'.'_index')) {
                $table->string('guid',100)->index()->change();
            }



            if (!Schema::hasColumn($this->getTable(), 'guid')) {
                $table->string('guid')->nullable();
            }
            if (!Schema::hasColumn($this->getTable(), 'category_id')) {
                $table->integer('category_id')->nullable();
            }
            if (!Schema::hasColumn($this->getTable(), 'author_id')) {
                $table->integer('author_id')->nullable();
            }
            if (!Schema::hasColumn($this->getTable(), 'subtitle')) {
                $table->string('subtitle')->nullable();
            }
            if (!Schema::hasColumn($this->getTable(), 'image')) {
                $table->string('image')->nullable();
            }
            if (!Schema::hasColumn($this->getTable(), 'image_alt')) {
                $table->string('image_alt')->nullable();
            }
            if (!Schema::hasColumn($this->getTable(), 'image_title')) {
                $table->string('image_title')->nullable();
            }
            if (!Schema::hasColumn($this->getTable(), 'meta_description')) {
                $table->text('meta_description')->nullable();
            }
            if (!Schema::hasColumn($this->getTable(), 'meta_keywords')) {
                $table->text('meta_keywords')->nullable();
            }
            if (!Schema::hasColumn($this->getTable(), 'content')) {
                $table->text('content')->nullable();
            }
            if (!Schema::hasColumn($this->getTable(), 'published')) {
                $table->boolean('published')->nullable();
            }
            if (!Schema::hasColumn($this->getTable(), 'created_by')) {
                $table->string('created_by')->nullable();
            }
            if (!Schema::hasColumn($this->getTable(), 'updated_by')) {
                $table->string('updated_by')->nullable();
            }


            if (!Schema::hasColumn($this->getTable(), 'url')) {
                $table->string('url')->nullable();
            }
            if (!Schema::hasColumn($this->getTable(), 'url_lang')) {
                $table->text('url_lang')->nullable();
            }
            if (!Schema::hasColumn($this->getTable(), 'image_resize_src')) {
                $table->text('image_resize_src')->nullable();
            }
            if (!Schema::hasColumn($this->getTable(), 'linked_count')) {
                $table->text('linked_count')->nullable();
            }
            if (!Schema::hasColumn($this->getTable(), 'related_count')) {
                $table->text('related_count')->nullable();
            }
            if (!Schema::hasColumn($this->getTable(), 'relatedrev_count')) {
                $table->text('relatedrev_count')->nullable();
            }
            if (!Schema::hasColumn($this->getTable(), 'linkable_type')) {
                $table->string('linkable_type', 20)->index()->nullable();
            }
            //------- CHANGE INDEX-------
            $schema_builder = Schema::getConnection()
                ->getDoctrineSchemaManager()
                ->listTableDetails($table->getTable());

            if (!$schema_builder->hasIndex($this->getTable().'_'.'post_id'.'_index')) {
                $table->integer('post_id')->nullable()->index()->change();
            }
            // if (!$schema_builder->hasIndex($this->getTable().'_'.'type'.'_index')) {
            //     $table->string('type', 30)->nullable()->index()->change();
            // }
            if (!$schema_builder->hasIndex($this->getTable().'_'.'lang'.'_index')) {
                $table->string('lang', 3)->nullable()->index()->change();
            }
            //-------- CHANGE FIELD -------------
            $table->text('subtitle')->nullable()->change();
        });
    }

    //end up

    public function down()
    {
        Schema::dropIfExists($this->getTable());
    }

    //end down
}//end class
