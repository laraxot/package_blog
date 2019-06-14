<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogPostArticleCatsTable extends Migration
{
    protected $table = 'blog_post_article_cats';

    public function up()
    {
        if (!Schema::hasTable($this->table)) {
            Schema::create($this->table, function (Blueprint $table) {
                $table->increments('post_id');
                $table->timestamps();
                $table->string('updated_by', 255)->nullable();
                $table->string('created_by', 255)->nullable();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
