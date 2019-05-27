<?php
namespace XRA\Blog\Models;

use Carbon\Carbon;

//use Illuminate\Database\Eloquent\Model;
//use Laravel\Scout\Searchable;

//--- TRAITS ---
//use XRA\Blog\Models\Traits\LinkedTrait;
//use XRA\Extend\Traits\Updater;

/**
 * { item_description }
 * da fare php artisan scout:import XRA\Blog\Models\Post.
 *
 * @mixin \Eloquent
 */
class Event extends BaseModel
{
    //use Searchable; //se non si crea prima indice da un sacco di errori
    //use Updater;
    //use LinkedTrait;
    protected $table = 'blog_post_events';
    protected $fillable = ['post_id','date_start','date_end'];
    protected $appends = [];
    protected $dates = ['date_start','date_end','created_at', 'updated_at'];
    protected $primaryKey = 'post_id';
    public $incrementing = true;
    //----- relationship -----
    /* --https://josephsilber.com/posts/2018/07/02/eloquent-polymorphic-relations-morph-map
    public function address(){
        return $this->morphOne(Address::class, 'addressable');
    }
    */
    //----- mutators -----
    public function getDateStartAttribute($value){    
        $date_format='d/m/Y';//config('app.date_format')
        if(!is_object($value)){
            $value=Carbon::parse($value);//->format($date_format);
        }
        return $value->format($date_format);
    }
    public function getDateEndAttribute($value){    
        $date_format='d/m/Y';//config('app.date_format')
        if(!is_object($value)){
            $value=Carbon::parse($value);//->format($date_format);
        }
        return $value->format($date_format);
    }

    public function setDateStartAttribute($value){
        $date_format_js='dd/mm/yy';
        $date_format='d/m/Y';//config('app.date_format')
        $this->attributes['date_start']=Carbon::createFromFormat($date_format, $value);
    }

    public function setDateEndAttribute($value){
        $date_format_js='dd/mm/yy';
        $date_format='d/m/Y';//config('app.date_format')
        $this->attributes['date_end']=Carbon::createFromFormat($date_format, $value);
    }
    
}//end model
