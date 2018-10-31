<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBlogSettingsTable extends Migration {
	protected $table='blog_settings';
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		if (!Schema::hasTable($this->table)) {
		Schema::create($this->table, function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('text_editor');
			$table->string('public_url');
			$table->timestamps();
			$table->string('created_by')->nullable();
			$table->string('updated_by')->nullable();
			$table->softDeletes();
			$table->string('deleted_by')->nullable();
			$table->string('deleted_ip')->nullable();
			$table->string('created_ip')->nullable();
			$table->string('updated_ip')->nullable();
			$table->string('guid')->nullable();
		});
		}
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop($this->table);
	}

}
