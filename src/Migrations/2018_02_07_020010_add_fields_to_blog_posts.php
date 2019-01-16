<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToBlogPosts extends Migration
{
    protected $table = 'blog_posts';

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
            if (!Schema::hasColumn($this->table, 'url')) {
                $table->string('url')->nullable();
            }
            if (!Schema::hasColumn($this->table, 'url_lang')) {
                $table->text('url_lang')->nullable();
            }
            if (!Schema::hasColumn($this->table, 'image_resize_src')) {
                $table->text('image_resize_src')->nullable();
            }
            if (!Schema::hasColumn($this->table, 'linked_count')) {
                $table->text('linked_count')->nullable();
            }
            if (!Schema::hasColumn($this->table, 'related_count')) {
                $table->text('related_count')->nullable();
            }
            if (!Schema::hasColumn($this->table, 'relatedrev_count')) {
                $table->text('relatedrev_count')->nullable();
            }
            if (!Schema::hasColumn($this->table, 'linkable_type')) {
                $table->string('linkable_type', 20)->index()->nullable();
            }
            //------- CHANGE INDEX-------
            $schema_builder = Schema::getConnection()
                ->getDoctrineSchemaManager()
                ->listTableDetails($table->getTable());

            if (!$schema_builder->hasIndex($this->table.'_'.'post_id'.'_index')) {
                $table->integer('post_id')->nullable()->index()->change();
            }
            if (!$schema_builder->hasIndex($this->table.'_'.'type'.'_index')) {
                $table->string('type', 30)->nullable()->index()->change();
            }
            if (!$schema_builder->hasIndex($this->table.'_'.'guid'.'_index')) {
                //    $table->string('guid',30)->nullable()->index()->change();
            }
            if (!$schema_builder->hasIndex($this->table.'_'.'lang'.'_index')) {
                $table->string('lang', 3)->nullable()->index()->change();
            }
            //-------- CHANGE FIELD -------------
            $table->text('subtitle')->nullable()->change();
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
