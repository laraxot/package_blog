<?php



namespace XRA\Blog;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use XRA\Blog\Models\Post;
//-------models-----------
use XRA\Blog\Models\PostRelated;
//use XRA\Blog\Models\PostRev;
use XRA\Blog\Models\PostShopItem;
use XRA\Extend\Traits\ServiceProviderTrait;

class BlogServiceProvider extends ServiceProvider
{
    use ServiceProviderTrait{
        boot as protected bootTrait;
    }

    protected $model = null;

    public function boot(\Illuminate\Routing\Router $router)
    {
        //die('['.__LINE__.']['.__FILE__.']');
        //https://stackoverflow.com/questions/42567445/how-to-bind-multiple-related-parameters-in-one-route-in-laravel

        //--------- MIDDLEWARE
        $router->aliasMiddleware('editor', XRA\Blog\Middleware\Editor::class);

        //----------ROUTE PATTERN

        if (\is_array(config('xra.model'))) {
            $pattern = \implode('|', \array_keys(config('xra.model')));
            //*
            $patternC = \str_replace('|', ' ', $pattern);
            $patternC = \ucwords($patternC);
            $patternC = \str_replace(' ', '|', $patternC);
            $pattern .= '|'.$patternC;
            //*/
            for ($i = 0; $i < 4; ++$i) {
                $container_name = 'container';
                $container_name .= $i;
                $router->pattern($container_name, '/|'.$pattern.'|/i');
            }
        }

        //--------- ROUTE BIND
        //*
        $router->bind('lang', function ($value) {
            \App::setLocale($value);

            return $value;
        });
        $lang = \App::getLocale();
        //*
        for ($i = 0; $i < 4; ++$i) {
            $container_name = 'container'.$i;
            $router->bind($container_name, function ($value) use ($lang) {
                $rows = Post::where('lang', $lang)
                        ->where('guid', $value)
                        ->where('type', $value)
                        ;
                if ($rows->exists()) {
                    return $rows->first();
                }

                return $value;
            });
        }
        //*/
        //*
        for ($i = 0; $i < 4; ++$i) {
            $item_name = 'item';
            $container_name = 'container';
            $item_name .= $i;
            $container_name .= $i;
            $router->bind($item_name, function ($value) use ($container_name,$lang,$i) {
                if (0 == $i) {
                    $rows = Post::where('lang', $lang)
                        ->where('guid', $value);
                    if (request()->route()->hasParameter($container_name)) {
                        $container_curr = request()->$container_name;
                        if (!\is_object($container_curr)) {
                            echo '<pre>';
                            \print_r($container_curr);
                            echo '</pre>';
                            ddd($params);
                        }
                        $rows = $rows->where('type', $container_curr->type);
                    }
                } else {
                    $container_curr = request()->$container_name;
                    $item_name_prev = 'item'.($i - 1);
                    $item_prev = request()->$item_name_prev;
                    $rows = $item_prev->related($container_curr->type)->where('guid', $value);
                }
                if ($rows->exists()) {
                    return $rows->first();
                }

                return $value;
            });
        }
        //*/
        //*/
        //*/
        //----------- BLADE IF
        //----------- BLADE DIRETTIVE
        /*
        Blade::macro('directiveWithArgs', function ($name, callable $handler) {
            Blade::directive($name, function($expression) use ($handler) {
                $args = eval("return [{$expression}];");
                return $handler(...$args);
            });
        });
        */

        Blade::directive('editorNotCache', function ($expression) {
            if (starts_with($expression, '(')) {
                $expression = \mb_substr($expression, 1, -1);
            }
            $expression_array = \explode(',', $expression);
            list($row, $view, $params, $time, $id) = $expression_array;
            $expression_cache = \implode(',', (\array_slice($expression_array, 1)));
            //dd();
            //dd(get_defined_vars());
            //return '['.$view.']';;;
            return "<?php 
				if (\Illuminate\Support\Facades\Blade::check('editor', $row)){
					echo ".'$__env'."->make($view,$params, array_except(get_defined_vars(), array('__data', '__path')))->render();
				}else{
					echo app()->make('partialcache')
				->cache(array_except(get_defined_vars(), ['__data', '__path']), ".$expression_cache.');
				}
			?>';
            /*
            return "<?php echo app()->make( $view , array_except(get_defined_vars(), ['__data', '__path']))->render(); ?>";
            */
            /*
            return "<?php echo app()->make( $view , array_except(get_defined_vars(), ['__data', '__path']))->render(); ?>";
            //*/

            /*
            return "<?php echo app()->make('partialcache')
                ->cache(array_except(get_defined_vars(), ['__data', '__path']), {$expression}); ?>";
            //*/
        });

        // Add @var for Variable Assignment
        // Example: @var('foo', 'bar') cosi' tolgo tutte le inizializzazioni aprendo php
        Blade::directive('var', function ($expression) {
            // Strip Open and Close Parenthesis
            $expression = \mb_substr(\mb_substr($expression, 0, -1), 1);

            // Split variable and its value
            list($variable, $value) = \explode('\',', $expression, 2);

            // Ensure variable has no spaces or apostrophes
            $variable = \trim(\str_replace('\'', '', $variable));

            // Make sure that the variable starts with $
            if (!starts_with($variable, '$')) {
                $variable = '$'.$variable;
            }

            $value = \trim($value);

            return "<?php {$variable} = {$value}; ?>";
        });

        $this->bootTrait($router);
    }

    /*
    public static function homePosts(){
        return Post::all();
    }

    public static function getPost($guid){
        $row=Post::firstOrCreate(['guid'=>$guid]);
        $out=view('pub_theme::layouts.post')->with('row', $row);
        return $out->__toString();
    }

    public static function ofType($type,$related_id=null){
        $rows=Post::where('type',$type)->where('lang',\App::getLocale());
        if($related_id!==null){
        }
        return $rows;
    }
    */
    public static function ofRelatedType($type)
    {
        //if($this->model==null) $this->model=new Post;
        //$rows=new PostRev;
        $rows = new Post();

        return $rows->ofRelatedType($type);
        /*
        $rows=$rows->relatedType($type);
        */
    //return $rows;
    /*
    $rows=new PostRev;
    //$rows=$rows->relatedrev()->wherePivot('type',$type);
    $rows=$rows->whereHas('related',function($query) use($type){
        $query->where('blog_post_related.type',$type);
    })->where('lang',\App::getLocale());
    return $rows;
    */
    }

    public static function getRoot($root)
    {
        //return Post::with(['related','relatedrev','archive'])->where('lang',\App::getLocale())->where('type',$root)->where('guid',$root)->first();
        return Post::with(['related', 'relatedrev'])->firstOrCreate(['lang' => \App::getLocale(), 'type' => $root, 'guid' => $root], ['title' => $root]); //->with(['relatedrev']);
    }

    public static function rows()
    {
        //$rows=new PostRev;
        $rows = new Post();
        $rows = $rows->where('lang', \App::getLocale())->with(['related', 'parentPost']);

        return $rows;
    }

    public static function postRelated($params)
    {
        $rows = new PostRelated();
        \extract($params);
        if (isset($type)) {
            $rows = $rows->where('type', $type);
        }

        return $rows->with(['post', 'related']);
    }

    public static function shopItems()
    {
        $rows = new PostShopItem();

        return $rows;
    }

    /*
    public static function ofParent($related_id){
        $rows=new Post;
        $rows=$rows->relatedrev()->wherePivot('related_id',$related_id)->wherePivot('type','parent');
        return $rows;
    }
    */

//-----------------------------------------------
}//end class
