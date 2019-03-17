<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use XRA\Blog\Models\Page;

class CreateBlogPostPagesTable extends Migration
{
    public function getTable()
    {
        return with(new Page())->getTable();
    }

    public function up()
    {
        if (!Schema::hasTable($this->getTable())) {
            Schema::create($this->getTable(), function (Blueprint $table) {
                //$table->increments('id');
                $table->increments('post_id')->index();
                $table->datetime('published_at')->nullable();
                $table->timestamps();
            });
        }
        Schema::table($this->getTable(), function (Blueprint $table) {
            if (!Schema::hasColumn($this->getTable(), 'updated_by')) {
                $table->string('updated_by')->nullable()->after('updated_at');
            }
            if (!Schema::hasColumn($this->getTable(), 'created_by')) {
                $table->string('created_by')->nullable()->after('created_at');
            }
            if (!Schema::hasColumn($this->getTable(), 'layout_position')) {
                $table->string('layout_position')->nullable();
            }
            $sql='ALTER TABLE '.$this->getTable().' CHANGE COLUMN post_id post_id INT(16) NOT NULL AUTO_INCREMENT FIRST;';
            \DB::unprepared($sql);
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->getTable());
    }
}
