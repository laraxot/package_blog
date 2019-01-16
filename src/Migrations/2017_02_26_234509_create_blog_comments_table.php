<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogCommentsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('blog_comments')) {
            Schema::create('blog_comments', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id');
                $table->integer('post_id');
                $table->text('comment');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('blog_comments');
    }
}
