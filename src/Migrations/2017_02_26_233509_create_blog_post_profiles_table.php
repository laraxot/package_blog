<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogPostProfilesTable extends Migration
{
    protected $table = 'blog_post_profiles';

    public function up()
    {
        if (!Schema::hasTable($this->table)) {
            Schema::create($this->table, function (Blueprint $table) {
                $table->integer('post_id');
                $table->index('post_id');
                //$table->string('article_type',50)->nullable();
                //$table->datetime('published_at')->nullable();
                $table->text('bio')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
