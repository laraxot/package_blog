<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBlogPostShopItemsTable extends Migration
{
    protected $table = 'blog_post_shop_items';

    /**
     * Run the migrations.
     */
    public function up()
    {
        if (!Schema::hasTable($this->table)) {
            Schema::create($this->table, function (Blueprint $table) {
                $table->increments('id');
                $table->integer('post_cat_id');
                $table->integer('post_id');
                $table->integer('post_var_cat_id');
                $table->string('post_id_adds');
                $table->string('post_id_subs');
                $table->integer('num')->nullable();
                $table->string('created_by')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop($this->table);
    }
}
