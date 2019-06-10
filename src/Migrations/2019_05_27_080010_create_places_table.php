<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
//----- models -----
use XRA\Blog\Models\Place as MyModel;

//--
/*
https://phppot.com/php/php-star-rating-system-with-javascript/
https://www.phpzag.com/star-rating-system-with-ajax-php-and-mysql/
*/


class CreatePlacesTable extends Migration
{
    public function getTable(){
        return with(new MyModel())->getTable();
    }

    public function up(){
        //----- create -----
        if (!Schema::hasTable($this->getTable())) {
            Schema::create($this->getTable(), function (Blueprint $table) {
                $table->increments('id');
                $table->nullableMorphs('post');
                $table->string('formatted_address')->nullable();
                $table->decimal('latitude', 15, 10)->nullable();
                $table->decimal('longitude', 15, 10)->nullable();
                //$table->string('post_type',50)->index()->nullable();
                $address_components = MyModel::$address_components;
                foreach ($address_components as $el) {
                    if (!Schema::hasColumn($this->getTable(), $el)) {
                        $table->string($el)->nullable();
                    }
                    if (!Schema::hasColumn($this->getTable(), $el.'_short')) {
                        $table->string($el.'_short')->nullable();
                    }
                }
                
                $table->string('nearest_street')->nullable();


                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('deleted_by')->nullable();
                $table->timestamps();
            });
        }
        //----- update -----
        Schema::table($this->getTable(), function (Blueprint $table) {
            if (!Schema::hasColumn($this->getTable(), 'post_type')) {
                //$table->string('post_type',50)->index()->nullable();
                //$table->morphs('post');
            };
            if (!Schema::hasColumn($this->getTable(), 'formatted_address')) {
                $table->string('formatted_address',150)->nullable();
                //$table->morphs('post');
            };
            /*
            if (!Schema::hasColumn($this->getTable(), 'date_start')) {
                $table->dateTime('date_start')->nullable();
                $table->dateTime('date_end')->nullable();
            };

            if (!Schema::hasColumn($this->getTable(), 'created_by')) {
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('deleted_by')->nullable();
            };
            $sql='ALTER TABLE '.$this->getTable().' CHANGE COLUMN post_id post_id INT(16) AUTO_INCREMENT FIRST;';
            \DB::unprepared($sql);
            */
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->getTable());
    }
}
