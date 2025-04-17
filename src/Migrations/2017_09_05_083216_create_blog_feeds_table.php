<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogFeedsTable extends Migration
{
    protected $table = 'blog_feeds';

    public function up()
    {
        if (!Schema::hasTable($this->table)) {
            Schema::create($this->table, function (Blueprint $table) {
                $table->integer('post_id')->index();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
