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
                $table->string('updated_by')->nullable();
                $table->string('created_by')->nullable();
            });
        }
        Schema::table($this->table, function (Blueprint $table) {
            if (!Schema::hasColumn($this->table, 'updated_by')) {
                $table->string('updated_by')->nullable()->after('updated_at');
            }
            if (!Schema::hasColumn($this->table, 'created_by')) {
                $table->string('created_by')->nullable()->after('created_at');
            }
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
