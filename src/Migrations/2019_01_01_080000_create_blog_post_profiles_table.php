<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use XRA\Food\Models\Profile as MyModel;  //blog o food ?

class CreateBlogPostProfilesTable extends Migration
{
    //protected $table = 'blog_post_profiles';
    public function getTable()
    {
        return with(new MyModel())->getTable();
    }


    public function up()
    {
        if (!Schema::hasTable($this->getTable())) {
            Schema::create($this->getTable(), function (Blueprint $table) {
                $table->increments('post_id')->primary();
                //$table->string('article_type',50)->nullable();
                //$table->datetime('published_at')->nullable();
                $table->text('bio')->nullable();
                $table->timestamps();
            });
        }
        Schema::table($this->getTable(), function (Blueprint $table) {
            //$table->increments('post_id')->change();
            //->autoIncrement()
            $sql='ALTER TABLE '.$this->getTable().' CHANGE COLUMN post_id post_id INT(16) NOT NULL AUTO_INCREMENT FIRST;';
            \DB::unprepared($sql);
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->getTable());
    }
}
