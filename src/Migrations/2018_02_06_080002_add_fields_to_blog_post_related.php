<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToBlogPostRelated extends Migration{
    protected $table='blog_post_related';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::table($this->table, function (Blueprint $table) {
            if (!Schema::hasColumn($this->table, 'price')) {
                $table->decimal('price',10,3)->nullable();
            }
            if (!Schema::hasColumn($this->table, 'price_currency')) {
                $table->string('price_currency')->nullable();
            }
            if (!Schema::hasColumn($this->table, 'launch_available')) {
                $table->boolean('launch_available')->nullable();
            }
            if (!Schema::hasColumn($this->table, 'dinner_available')) {
                $table->boolean('dinner_available')->nullable();
            }
            if (!Schema::hasColumn($this->table, 'pos')) {
                $table->integer('pos')->nullable();
            }
            if (!Schema::hasColumn($this->table, 'note')) {
                $table->text('note')->nullable();
            }
            if (Schema::hasColumn($this->table, 'note')) {
                $table->text('note')->nullable()->change();
            }
            //------- CHANGE-------
             $schema_builder = Schema::getConnection()
                ->getDoctrineSchemaManager()
                ->listTableDetails( $table->getTable() );

            if(! $schema_builder->hasIndex($this->table.'_'.'post_id'.'_index') ){
                $table->integer('post_id')->nullable()->index()->change();
            }
            if(! $schema_builder->hasIndex($this->table.'_'.'related_id'.'_index') ){
                $table->integer('related_id')->nullable()->index()->change();
            }
            if(! $schema_builder->hasIndex($this->table.'_'.'type'.'_index') ){
                $table->string('type',50)->nullable()->index()->change();
            }
            if (!Schema::hasColumn($this->table, 'related_type')) {
                $table->string('related_type',50)->nullable()->index();
            }
            if (!Schema::hasColumn($this->table, 'post_type')) {
                $table->string('post_type',50)->nullable()->index();
            }
            
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->dropColumn(['price_currency']);
        });
    }
}
