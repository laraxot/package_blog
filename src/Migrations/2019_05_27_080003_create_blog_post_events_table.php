<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
//----- models -----
use XRA\Blog\Models\Event as MyModel;


class CreateBlogPostEventsTable extends Migration
{
    public function getTable(){
        return with(new MyModel())->getTable();
    }

    public function up(){
        //----- create -----
        if (!Schema::hasTable($this->getTable())) {
            Schema::create($this->getTable(), function (Blueprint $table) {
                $table->increments('post_id');
                //$table->string('article_type',50)->nullable();
                //$table->datetime('published_at')->nullable();
                //$table->text('bio')->nullable();
                $table->timestamps();
            });
        }
        //----- update -----
        Schema::table($this->getTable(), function (Blueprint $table) {
            if (!Schema::hasColumn($this->getTable(), 'date_start')) {
                $table->dateTime('date_start')->nullable();
                $table->dateTime('date_end')->nullable();
            };

            if (!Schema::hasColumn($this->getTable(), 'created_by')) {
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('deleted_by')->nullable();
            };
        });

    }

    public function down()
    {
        Schema::dropIfExists($this->getTable());
    }
}
