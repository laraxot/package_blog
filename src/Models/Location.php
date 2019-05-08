<?php
namespace XRA\Blog\Models;

//use Illuminate\Database\Eloquent\Model;
//------ traits ----
//--------- models --------
use XRA\Blog\Models\Post;
use XRA\Blog\Models\PostRelated;
//--- services
use XRA\Extend\Services\ThemeService;
use XRA\Extend\Services\ImportService;

//--- traits 
//use XRA\Blog\Models\Traits\LinkedTrait;

class Location extends BaseModel
{
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships; 
    //https://github.com/staudenmeir/eloquent-has-many-deep#morphedbymany
    //use LinkedTrait;
    //protected $table = "blog_post_restaurants";
    //protected $primaryKey = 'post_id';
    public $table = 'import_items'; //<name pack>_items
    protected $primaryKey = 'post_id';
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    ///*
    protected $fillable = ['post_id', 'latitude', 'longitude', 'address1', 'address2', 'address3', 'city', 'zip_code', 'country', 'state', 'phone', 'display_phone', 'price', 'is_closed', 'review_count', 'yelp_url', 'rating'];

    public static $food_engines = ['justeat', 'sgnamit', 'googleplace', 'foodracers',
            'foodora', 'moovenda', 'deliveroo',
            'bacchetteforchette',
            'theforkit', 'misiedocom',
            'yelp', 'zomato', 'restopolitanit',
            'mymenu', 'foodpanda', 'facebook',
    ];
    public static $address_components = [
            'premise', 'locality', 'postal_town',  
            'administrative_area_level_3','administrative_area_level_2',  'administrative_area_level_1', 
             'country', 
             'street_number', 'route', 'postal_code', 
             'googleplace_url',
            'point_of_interest', 'political', 'campground',
        ];

    /*
    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $this->importInit();
    }
    //*/

    //-----relationship------
    /*
    public function post()
    {
        $row = $this->hasOne(Post::class, 'post_id', 'post_id')
                ->where('lang', \App::getLocale())
                ->where('type', $this->post_type)
                ->withDefault()
                ;

        return $row;
    }
    */

    public function restaurantProviders()
    {
        $rows = $this->hasManyThrough(
            RestaurantProvider::class,
            Restaurant::class,
            'locality', // Foreign key on Restaurant table...
            'post_id', // Foreign key on posts table...
            'locality', // Local key on Location table...
            'post_id' // Local key on Restaurant table...
        );

        return $rows;
    }

    /*
    public function restaurants(){
        $rows=$this->hasMany(Restaurant::class,'locality','locality');
        $cuisineCat=\Request::input('cuisineCat');
        if($cuisineCat!=''){
            $cuisineCats=explode(',',$cuisineCat);
            foreach($cuisineCats as $cuisineCat){
                $rows=$rows->ofCuisineCat(trim($cuisineCat));
            }
        }
        return $rows;
    }
    */

    public function restaurants(){
        //col with da 78 a 40 queries
        //col with post da 40 a 21
        $related_table=with(new Restaurant)->getTable();
        return $this->hasMany(Restaurant::class,'locality','locality')
            ->join('blog_posts','blog_posts.post_id','=',$related_table.'.post_id')
            ->where('blog_posts.lang',$this->lang)
            ->where('blog_posts.post_type','restaurant')
            ->with(['cuisineCats','post']);
    }

    public function cuisineCats(){
        /*
         $rows = $this->hasManyThrough(
            CuisineCat::class,
            Restaurant::class,
            'locality', // Foreign key on Restaurant table...
            'post_id', // Foreign key on posts table...
            'locality', // Local key on Location table...
            'post_id' // Local key on Restaurant table...
        )->where('lang', \App::getLocale());
        ddd($rows->toSql()); 
        */
        //return $this->hasManyDeep(CuisineCat::class,['morphRelated',Restaurant::class]);
        //https://github.com/staudenmeir/eloquent-has-many-deep#morphedbymany
        $related_table=with(new CuisineCat)->getTable();
         return $this->hasManyDeepFromRelations($this->restaurants(), (new Restaurant)->cuisineCats())
         //* 
            ->join('blog_posts','blog_posts.post_id','=',$related_table.'.post_id')
            ->where('blog_posts.lang',$this->lang)
            ->where('blog_posts.post_type','cuisineCat')
            ->groupBy('blog_posts.guid')
            //*/
            ->with(['post']);
            ;


        ddd('in manutenzione');
        //ddd('a');
        $cuisineCats=$this->restaurants->map(function($item){
            return $item->cuisineCats;   
        });//()->cuisineCats();
        //ddd($cuisineCats);
        return $cuisineCats;
    }



    public function postRestaurants()
    {
        $rows = $this->hasManyThrough(
            Post::class,
            Restaurant::class,
            'locality', // Foreign key on Restaurant table...
            'post_id', // Foreign key on posts table...
            'locality', // Local key on Location table...
            'post_id' // Local key on Restaurant table...
        )->where('lang', \App::getLocale());

        /*
        select blog_posts.* 
        from blog_post_restaurants 
        join blog_posts
        on blog_posts.post_id=blog_post_restaurants.post_id
        and blog_posts.type='restaurant'
        where locality='Mogliano Veneto'
        and lang='it'
        */

        return $rows;
    }

    public function postRelatedRestaurants()
    {
        //meglio passare al belogsToMany per le svariate opzioni in piu
        $rows = $this->hasManyThrough(
            PostRelated::class,
            Restaurant::class,
            'locality', // Foreign key on Restaurant table...
            'post_id', // Foreign key on posts table...
            'locality', // Local key on Location table...
            'post_id' // Local key on Restaurant table...
        )->where('lang', \App::getLocale());

        return $rows;
    }

    /*
    public function localityPostRestaurants(){
        return $this->belongsToMany(Post::class, 'blog_post_related', 'post_id', 'related_id','post_id','post_id');
    }
    */

    public function postCuisineCats()
    {
        //*//--- da 291 a 112 senza
        $lang=\App::getLocale();
        $restaurants=$this->restaurants;
        $restaurants_ids=$restaurants->pluck('post_id');
        
        $cuisine_cats=CuisineCat::whereHas('restaurants',function ($query) use($restaurants_ids){
            $query->whereIn('blog_post_related.post_id',$restaurants_ids);
        });
        $cuisine_cats_ids=$cuisine_cats->pluck('post_id');
        foreach($restaurants_ids as $r_id){
            PostRelated::firstOrCreate(['post_id'=>$this->post_id,'related_id'=>$r_id,'type'=>'location_x_restaurant']);
        }
        foreach($cuisine_cats_ids as $c_id){
            PostRelated::firstOrCreate(['post_id'=>$this->post_id,'related_id'=>$c_id,'type'=>'location_x_cuisineCat']);
        }
        //*/

        return $this->related()->wherePivot('type', 'location_x_cuisineCat');

        /*
        $posts=Post::where('lang',$lang)
            ->where('type','CuisineCat')
            ->whereIn('post_id',$cuisine_cats_ids);
        
        return $posts;
        */

        /*
        $rows=Post::where('lang',$lang)
            ->where('type','CuisineCat')
            ->whereHas('linked',function ($query) use($restaurant_ids){
                $query->whereIn('post_id',$restaurant_ids);
            });
        
        ;
        */
        
        ddd($posts->get());

        /*
        return \DB::raw("select * from blog_posts where lang='it' and type='cuisineCat' and post_id in
        (select distinct blog_post_related.related_id 
        from blog_post_restaurants 
        join blog_posts
        on blog_posts.post_id=blog_post_restaurants.post_id
        and blog_posts.type='restaurant'
        join blog_post_related on
        blog_post_related.post_id=blog_posts.post_id
        where locality='Mogliano Veneto'
        and blog_post_related.type='restaurant_x_cuisineCat'
        and lang='it')");
        */
        /*
        return Post::select('blog_posts.*')
            ->join('blog_post_restaurants','blog_post_restaurants.post_id','blog_posts.post_id')
            ->where('blog_posts.type','restaurant')
            ->where('locality','Mogliano Veneto')
            ->where('lang', \App::getLocale())
            ->join('blog_post_related','blog_post_related.related_id','blog_posts.post_id')
            ->where('blog_post_related.type','restaurant_x_cuisineCat')

            ;
        */

        $restaurants=$this->restaurants;
        $rows=$this->hasMany(Post::class,'post_id',function($item,$key){
            ddd($item);
        });
        ddd($rows);

        //da fare .. dovrebbe essere il throught
        ///*
        $rows = $this->hasMany(Restaurant::class, 'locality', 'locality')
            //->distinct()
            ->select('blog_posts.*')
            ->join('blog_post_related', 'blog_post_related.post_id', 'blog_post_restaurants.post_id')
            ->where('blog_post_related.type', 'restaurant_x_cuisineCat')
            ->join('blog_posts', 'blog_posts.post_id', 'blog_post_related.related_id')
            ->groupBy('blog_posts.post_id')
            ->orderBy('blog_posts.title')
            ;

        return $rows;
        //*/
        //echo '<pre>';print_r($rows->toSql());echo '</pre>';
        //select * from `blog_post_restaurants` where `blog_post_restaurants`.`locality` = ? and `blog_post_restaurants`.`locality` is not null
        //dd($rows->get()[0]);

        $rows = $this->postRelatedRestaurants()->where('type', 'restaurant_x_cuisineCat')->distinct();
        ddd($rows->get()[0]);
        /*
        $rows=$this->restaurants->map(function($row){
            return $row->related
                    ->where('pivot.type','restaurant_x_cuisineCat')
                    //->pluck('title','guid')
                    ;
        });
        return $rows->collapse()->sort();
        */

        $rows = $this->restaurants()->with('cuisineCats');
        $ris = collect();
        foreach ($rows->get() as $row) {
            $ris = $ris->merge($row->cuisineCats);
        }
        $ris = $ris->unique('guid');

        return $ris;
        //dd($ris)->unique('guid');
        echo '<ul>';
        foreach ($ris as $item) {
            echo '<li>'.$item->post_type.'  '.$item->post_id.'] '.$item->title.'  '.$item->lang.'</li>';
        }
        echo '</ul>';

        die('['.__LINE__.']['.__FILE__.']');

        return $rows;

        $rows = $this->postRestaurants()->get()->map(function ($row) {
            return $row->related->where('pivot.type', 'restaurant_x_cuisineCat');
        });

        return $rows;
        /*
        $rows=$this->restaurants->map(function($row){
            //return $row->relatedType('restaurant_x_cuisineCat')->get()->pluck('title','guid');
            return $row->related->where('pivot.type','restaurant_x_cuisineCat');
        });
        */
        //$row=$this->restaurants()->ofRelatedType('cuisineCat');
        return $this->belongsToMany(Post::class, 'blog_post_related', 'post_id', 'post_id', 'locality', 'post_id');

        return $rows;
    }

    public function listCuisineCats()
    {
        $rows = $this->restaurants->map(function ($row) {
            return $row->related
                    ->where('pivot.type', 'restaurant_x_cuisineCat')
                    ->pluck('title', 'guid');
        });

        return $rows->collapse()->sort();
    }

    //-------- mutators ------

    public function getTabsAttribute($value){
        if($this->post->guid!=$this->post->post_type){
            return ['cuisineCat','restaurant'];
        }
    }



    public function getFoodEnginesAttribute($value)
    {
        return self::$food_engines;
    }

    public function getTypeAttribute($value)
    {
        return 'location';
    }
    /*
    public function getTitleAttribute($value)
    {
        return $this->locality;
    }
    
    public function getGuidAttribute($value)
    {
        $guid = str_slug($this->locality);

        return $guid;
    }
    */
    public function getRestaurantsCountAttribute($value)
    {
        return $this->restaurants->count();
    }

    public function getCuisineCatsCountAttribute($value)
    {
        return '?? da fare';
    }

    public function getImageSrcAttribute($value)
    {
        if ('' == $value) {
            $ris = ImportService::pixabay(['q' => $this->locality.' '.$this->country]);
            if (\is_object($ris)) {
                $value = $ris->webformatURL;
            }
        }

        return $value;
    }

    public function getUrlAttribute($value)
    {
        if (!$this->post) {
            $post = Post::firstOrCreate(
                ['guid' => $this->guid, 'type' => $this->post_type, 'lang' => \App::getLocale()],
                ['title' => $this->title]
            );
            $post->title = $this->title;
            $post->save();
            if ($this->post_id != $post->post_id) {
                self::where('post_id', $post->post_id)->delete();
                $this->post_id = $post->post_id;
                $this->save();
            }
            $this->post = $post;
            //return $post->url;
        }

        return $this->post->url;
    }

    //end getUrlAttribute

    //--------------Functions ------------
    public function formFields()
    {
        //$view=ThemeService::getView(); //non posso usarla perche' restituisce la view del chiamante
        if (!\is_object($this)) {
            ddd($this);
        }

        return view('food::admin.location.form_fields')->with('row', $this);
        //return '['.__LINE__.']['.__FILE__.']Campi Location ';
    }
}
