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
//class PostRelated extends Model {
class PostRelatedPivot extends Pivot
{
    protected $table = 'blog_post_related';
    protected $primaryKey = 'id';

    //$timestamps = false;
    /*
    protected $fillable =   [
                                'email',
                                'verification_token'
                            ];
    */
    public function post()
    {
        $rel = $this->hasOne(Post::class, 'post_id', 'post_id')->where('lang', \App::getLocale());
        $tmp = \explode('_x_', $this->type);
        if (2 == \count($tmp)) {
            $rel = $rel->where('type', $tmp[0]);
        } else {
            ddd($this);
        }

        return $rel;
    }

    public function related()
    {
        $rel = $this->hasOne(Post::class, 'post_id', 'related_id')->where('lang', \App::getLocale());
        $tmp = \explode('_x_', $this->type);
        if (2 == \count($tmp)) {
            $rel = $rel->where('type', $tmp[1]);
        } else {
            ddd($this);
        }

        return $rel;
    }

    //------------- MUTUATORS -----------
    /*
    public function getPriceAttribute($value){
        //dd($this);
        $row=PostRelated::where('post_id',$this->post_cat_id)->where('related_id',$this->post_id)->first();
        return $row->price;
        //return 10;
    }

    public function getSonsCountAttribute($value){
        if ($value=='') {
            $value=$this->where('related_id', $this->post_id)->count();
            $this->sons_count=$value;
            $this->save();
        }
        return $value;
    }
    */

    //public function attachType($a){
    //    return true;
    //}
    public function getRouteN($n, $act)
    {
        $params = \Route::current()->parameters();
        $params['container'.$n] = $this->post->type;
        $params['item'.$n] = $this->post->guid;
        $params['container'.($n + 1)] = $this->related->type;
        $params['item'.($n + 1)] = $this->related->guid;
        $r = '';
        for ($i = 0; $i <= ($n + 1); ++$i) {
            $r .= 'container'.$i.'.';
        }
        $route = $r.$act;
        if ('container0.container1.container2.container3.show' == $route) {
            //echo '<h3>'.$route.'</h3>';
            //ddd(array_keys($params));
            return '1';
        }
        if (in_admin()) {
            $route = 'blog.'.$route;
        }

        return route($route, $params);
    }

    public function getUrlAct($act){
        $params = \Route::current()->parameters();
        list($containers,$items)=$this->params2ContainerItem($params);
        $n_containers=count($containers);
        $n_items=count($items);
        //ddd($this->type); //restaurant_x_cuisine
        //ddd($container[0]->type); // restaurant
        //ddd($container[1]->type); // menu
        //ddd($this->post->type); //restaurant
        //ddd($this->related->type); //cuisine
        //$i=collect($container)->where('type',$this->post->type)->first();
        $post=$this->post;
        $related=$this->related;
        /*
        $i=collect($container)->each(function($item,$key) use($post){
            if($item->type==$post->type) return $key;
        });
        */
        $i=null; // quando trovo la collection giusta la sostituisco
        foreach($containers as $k=>$container){
            if($container->type == $post->type){
                $i=$k; break;
            }
        }
        $j=null;
        foreach($containers as $k=>$container){
            if($container->type == $related->type){
                $j=$k; break;
            }
        }
        $routename=null;

        $roots=config('xra.roots');
        if(!is_array($roots)){
            $roots=[];
        }
        /*
        ddd($this->related);
        if(strtolower($this->related->type)!=strtolower($this->related->guid) && in_array($this->related->type,$roots)){
            return $this->getRouteN(0, $act);//.'#2['.$i.']['.$j.']';
        }
        */


        if($i!==null && $j===null){
            return $this->getRouteN($i, $act); //.'#1';
        }
        if($i!==null && $j!==null && $j==$i+1){
            return $this->getRouteN($i, $act); //.'#2';
        }
        if($i===null && $j===null){ //esempio da /restaurant/ristotest/menu/edit    cambio un piatto percio cuisine recipe
            //ddd(count($items));
            //se menu avesse "cuisines" allora
            //dovrei controllare se l'ultimo item ha cuisines ..
            return $this->getRouteN($n_items, $act);//.'#3'; 
        }

        ddd('<h3>['.$post->type.']['.$i.']['.$related->type.']['.$j.']['.$routename.']</h3>');
        //ddd($params);
        //ddd($j);
    }

    public function params2ContainerItem($params){
        $container=[];
        $item=[];
        foreach($params as $k=>$v){
            $pattern='/(container|item)([0-9]+)/';
            preg_match($pattern, $k,$matches);
            if(isset($matches[1]) && isset($matches[2]) ){
                $sk=$matches[1];
                $sv=$matches[2];
                $$sk[$sv]=$v;
            };
        }
        return [$container,$item];
    }    


    public function getUrlAct_old($act)
    {

        $params = \Route::current()->parameters();
        $routename = \Request::route()->getName();
        $routename_arr = \explode('.', $routename);
        $routename_arr = \array_slice($routename_arr, 0, -1);
        $last = last($routename_arr);
        $second_last = collect(\array_slice($routename_arr, -2))->first(); //penultimo
        if (null == $last) {
            return $this->getRouteN(0, $act); //.'#0';
        }
        $last_obj = $params[$last];
        $n = \str_replace('container', '', $last);
        if (!isset($params[$second_last])) {
            return '['.__LINE__.']['.__FILE__.']';
        }
        if (isset($params[$second_last])) {
            $second_last_obj = $params[$second_last];
            if (!\is_object($second_last_obj)) {
                ddd($second_last_obj);
            }
            if (!\is_object($last_obj)) {
                ddd($last_obj);
            }
            if (!\is_object($this->post)) {
                ddd($this->post);
            }
            if (!\is_object($this->related)) {
                $this->delete();
                ddd($this);
            }
            if ($second_last_obj->type == $this->post->type && $last_obj->type == $this->related->type) {
                return $this->getRouteN($n - 1, $act); //.'#1['.$n.']';
            }
        }

        if ($second_last_obj->type == $this->related->type) {
            return $this->getRouteN($n, $act); // forse -1
        }

        if ($last_obj->type != $this->post->type) {
            return $this->getRouteN($n + 1, $act); //.'#2['.$n.']['.$second_last_obj->type.']['.$this->post->type.']';
        }

        return $this->getRouteN($n, $act); //.'#3['.$n.']';
    }

    public function getUrlAttribute($value)
    {
        return $this->getUrlAct('show');
        /*
        $post_url=$this->post->type.'/'.$this->post->guid;
        $related_url=$this->related->type.'/'.$this->related->guid;
        $url=\Request::getPathInfo();
        if(ends_with($url,'/'.$post_url)){   //non mi convince ma per ora funziona
            return url($url.'/'.$related_url);
        }
        return url($this->post->lang.'/'.$post_url.'/'.$related_url);
        */
    }

    public function getStoreUrlAttribute($value)
    {
        return $this->getUrlAct('store');
    }

    public function getIndexUrlAttribute($value)
    {
        return $this->getUrlAct('index');
    }

    public function getIndexEditUrlAttribute($value)
    {
        return $this->getUrlAct('index_edit');
    }

    public function getCreateUrlAttribute($value)
    {
        return $this->getUrlAct('create');
    }

    public function getDestroyUrlAttribute($value)
    {
        return $this->getUrlAct('destroy');
    }

    public function getUpdateUrlAttribute($value)
    {
        return $this->getUrlAct('update');
    }

    public function getShowUrlAttribute($value)
    {
        return $this->getUrlAct('show');
    }

    public function getEditUrlAttribute($value)
    {
        return $this->getUrlAct('edit');
    }

    //--------------------------------------------------
    public function getAttachUrlAttribute($value)
    {
        return $this->getUrlAct('attach');
    }

    public function getDetachUrlAttribute($value)
    {
        return $this->getUrlAct('detach');
    }

    public function getMovedownUrlAttribute($value)
    {
        return $this->getUrlAct('movedown');
    }

    public function getMoveupUrlAttribute($value)
    {
        return $this->getUrlAct('moveup');
    }
}
