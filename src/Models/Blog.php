<?php
namespace XRA\Blog\Models;

use Illuminate\Database\Eloquent\Model;
//--- TRAITS ---
//use XRA\Blog\Models\Traits\LinkedTrait;

class Blog extends BaseModel
{
    //use LinkedTrait;
    protected $table = 'blog_posts';

    //--- relationship --
    public function archive()
    {
        $rows = $this->hasMany(Post::class, 'post_type', 'post_type')
                ->where('lang', $this->lang)
                ->where('guid', '!=', $this->post_type)
                ->with(['relatedrev', 'related']);
        if (\Request::has('lat') && \Request::has('lng')) {
            $currentLocation = [
                'latitude' => \Request::input('lat'),
                'longitude' => \Request::input('lng'),
            ];

            $distance = 30; //km
            $rows = $rows->findNearest($this->post_type, $currentLocation, $distance, 1000);
        }

        return $rows;
    }

    public function types()
    {  //-- da modifidare che mostri solo gli elementi con archive > 0
        return self::where('lang', \App::getLocale())->whereRaw('post_type=guid')
                /*
                ->whereHas('archive',function($query){
                    $query->where('id','=',1);
                })
                */
                ->has('archive','>',1)
                ;
    }

    public function firstItem()
    {
        return self::where('lang', \App::getLocale())->orderBy('updated_at')->first();
    }

    public function lastItem()
    {
        return self::where('lang', \App::getLocale())->orderBy('updated_at', 'desc')->first();
    }

    public function createJsonFileChart()
    {
        $rows = \DB::select("select date_format(created_at,'%Y-%m-%d') as x,count(*) as y
		from blog_posts
		group by date_format(created_at,'%Y-%m-%d') order by created_at desc limit 15");
        //dd(json_encode($rows->toArray()));
        //ddd(json_encode($rows));
        \File::put(public_path('test.json'), \json_encode($rows));
    }
}

/*
var data = input.map(function(item) {
      return {x: new Date(item["x"]), y: item["y"]};
 });
*/
