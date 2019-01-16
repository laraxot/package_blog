<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToBlogPostCats extends Migration
{
    protected $table = 'blog_post_cats';

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table($this->table, function (Blueprint $table) {
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
     */
    public function down()
    {
        Schema::table($this->table, function (Blueprint $table) {
            //    $table->dropColumn(['guid']);
        });
    }
}
