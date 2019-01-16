<?php



namespace XRA\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * XRA\Blog\Models\PostContent.
 *
 * @property \XRA\Blog\Models\Post $Post
 * @mixin \Eloquent
 */
class PostRelated extends Model
{
    //class PostRelated extends Pivot { diventato PostRelatedPivot
    protected $table = 'blog_post_related';
    //protected $primaryKey = 'post_id'; // mi da errore su aggiornamenti diretti
    //protected $primaryKey = 'id';
    //$timestamps = false;

    protected $fillable = [
                                'post_id',
                                'related_id',
                                'type',
                                'price',
                                'price_currency',
                                'pos',
                            ];

    /*
    public function post(){
    	return $this->belongsTo(Post::class, 'post_id', 'post_id');
        //return $this->hasOne(Post::class, 'post_id', 'post_id');
    }
    */
    /*
    public function related(){
        return $this->belongsTo(Post::class, 'related_id', 'post_id');
        //return $this->hasOne(Post::class, 'related_id', 'post_id');
    }
    */
    public function post_related_post()
    {
        return $this->hasMany(PostRelatedPost::class, 'post_related_id', 'id');
    }

    public function post($fieldname = null)
    {
        $rows = $this->belongsTo(Post::class, 'post_id', 'post_id');
        //return $rows;
        if (null == $fieldname) {
            return $rows;
        }
        $row = $rows->first();
        if ('url' == $fieldname) {
            return $row->url;
        }
        //echo '['.$this->post_id;
        //dd($row);
        return $row->$fieldname;
    }

    public function related($fieldname = null)
    {
        $rows = $this->belongsTo(Post::class, 'related_id', 'post_id'); // Post_id
        if (null == $fieldname) {
            return $rows;
        }
        $row = $rows->first();
        if ('url' == $fieldname) {
            return $row->url;
        }

        return $row->field($fieldname);
        /*
        if(in_array($fieldname,Post::fields()->all())) return $row->$fieldname;
        $model=config('xra.model.'.$row->type);
        $linked=$model::where('post_id',$row->post_id)->first();
        return $linked->$fieldname;
        */
    }

    public function getSonsCountAttribute($value)
    {
        if ('' == $value) {
            $value = $this->where('related_id', $this->post_id)->count();
            $this->sons_count = $value;
            $this->save();
        }

        return $value;
    }

    /**
     * { item_description }.
     */
    public static function deleteDuplicateRecords()
    {
        $duplicateRecords = self::selectRaw('post_id,related_id,type,count(*) as `occurences`')
            ->groupBy('post_id', 'related_id', 'type')
            ->having('occurences', '>', 1)
            ;
        foreach ($duplicateRecords->get() as $row) {
            self::where('post_id', $row->post_id)
                ->where('related_id', $row->related_id)
                ->where('type', $row->type)
                ->limit($row->occurences - 1)
                ->delete();
        }
    }

    //end deleteDuplicateRecords
}//end class
