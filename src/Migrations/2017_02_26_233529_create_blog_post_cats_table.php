<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogPostCatsTable extends Migration{
	protected $table='blog_post_cats';

	public function up(){
		if (!Schema::hasTable($this->table)) {
			Schema::create($this->table, function (Blueprint $table) {
				$table->integer('post_id')->index()->nullable();
				$table->string('created_by')->nullable();
				$table->string('updated_by')->nullable();
				//$table->softDeletes();
				$table->string('deleted_by')->nullable();
				$table->string('deleted_ip')->nullable();
				$table->string('created_ip')->nullable();
				$table->string('updated_ip')->nullable();
				$table->timestamps();
			});
		}
		
	}//end up

	public function down(){
		Schema::dropIfExists($this->table);
	}//end down
}//end class
