<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogPostsTable extends Migration
{
    protected $table = 'blog_posts';

    public function up()
    {
        if (!Schema::hasTable($this->table)) {
            Schema::create($this->table, function (Blueprint $table) {
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
        Schema::table($this->table, function (Blueprint $table) {
            if (!Schema::hasColumn($this->table, 'post_type')) {
                $table->string('post_type', 40)->after('type')->index()->nullable();
            }
        });
    }

    //end up

    public function down()
    {
        Schema::dropIfExists($this->table);
    }

    //end down
}//end class
