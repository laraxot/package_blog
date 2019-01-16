<?php



namespace XRA\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blog_posts';

    //--- relationship --
    public function archive()
    {
        $rows = $this->hasMany(Post::class, 'type', 'type')
                ->where('lang', $this->lang)
                ->where('guid', '!=', $this->type)
                ->with(['relatedrev', 'related']);
        if (\Request::has('lat') && \Request::has('lng')) {
            $currentLocation = [
                'latitude' => \Request::input('lat'),
                'longitude' => \Request::input('lng'),
            ];

            $distance = 30; //km
            $rows = $rows->findNearest($this->type, $currentLocation, $distance, 1000);
        }

        return $rows;
    }

    public function types()
    {
        return self::where('lang', \App::getLocale())->whereRaw('type=guid');
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
