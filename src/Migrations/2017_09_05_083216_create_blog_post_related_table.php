<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogPostRelatedTable extends Migration
{
    protected $table = 'blog_post_related';

    public function up()
    {
        if (!Schema::hasTable($this->table)) {
            Schema::create($this->table, function (Blueprint $table) {
                $table->increments('id');
                $table->integer('post_id')->nullable();
                $table->integer('related_id')->nullable();
                $table->integer('pos')->nullable();
                $table->string('type', 50)->nullable();
                $table->string('note')->nullable();
                $table->integer('sons_count')->nullable();
                $table->integer('parents_count')->nullable();
                $table->timestamps();
            });
        }

        Schema::table($this->table, function (Blueprint $table) {
            if (!Schema::hasColumn($this->table, 'price')) {
                $table->decimal('price', 10, 3)->nullable();
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
                ->listTableDetails($table->getTable());

            if (!$schema_builder->hasIndex($this->table.'_'.'post_id'.'_index')) {
                $table->integer('post_id')->nullable()->index()->change();
            }
            if (!$schema_builder->hasIndex($this->table.'_'.'related_id'.'_index')) {
                $table->integer('related_id')->nullable()->index()->change();
            }
            if (!$schema_builder->hasIndex($this->table.'_'.'type'.'_index')) {
                $table->string('type', 50)->nullable()->index()->change();
            }
            if (!Schema::hasColumn($this->table, 'related_type')) {
                $table->string('related_type', 50)->nullable()->index();
            }
            if (!Schema::hasColumn($this->table, 'post_type')) {
                $table->string('post_type', 50)->nullable()->index();
            }
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
