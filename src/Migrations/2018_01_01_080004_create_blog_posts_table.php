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
                $table->string('title');
                $table->string('subtitle')->nullable();
                $table->string('guid')->nullable();
                $table->string('type', 50)->nullable(); //da capire se fare tabella collegata o meno
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
            if (!Schema::hasColumn($this->getTable(), 'post_type')) {
                $table->string('post_type', 40)->after('type')->index()->nullable();
            }
            $schema_builder = Schema::getConnection()
                ->getDoctrineSchemaManager()
                ->listTableDetails($table->getTable());

            if (!$schema_builder->hasIndex($this->getTable().'_'.'guid'.'_index')) {
                $table->string('guid',100)->index()->change();
            }
        });
    }

    //end up

    public function down()
    {
        Schema::dropIfExists($this->getTable());
    }

    //end down
}//end class
