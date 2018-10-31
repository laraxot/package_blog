<?php

namespace XRA\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

use XRA\Extend\Traits\CrudSimpleTrait as CrudTrait;

/**
 * XRA\Blog\Models\PostContent
 *
 * @property-read \XRA\Blog\Models\Post $Post
 * @mixin \Eloquent
 */
//class PostRelated extends Model {
class PostRelatedPivot extends Pivot{
	protected $table = 'blog_post_related';
	protected $primaryKey = 'id';
	//$timestamps = false;
	/*
	protected $fillable =   [
								'email',
								'verification_token'
							];
	*/
	public function post(){
		$rel=$this->hasOne(Post::class, 'post_id', 'post_id')->where('lang',\App::getLocale());
		$tmp=explode('_x_',$this->type);
		if(count($tmp)==2){
			$rel=$rel->where('type',$tmp[0]);
		}else{
			ddd($this);
		}
		return $rel;
	}
	public function related(){
		$rel=$this->hasOne(Post::class, 'post_id', 'related_id')->where('lang',\App::getLocale());
		$tmp=explode('_x_',$this->type);
		if(count($tmp)==2){
			$rel=$rel->where('type',$tmp[1]);
		}else{
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
	public function getRouteN($n,$act){
		$params=\Route::current()->parameters();
		$params['container'.$n]=$this->post->type;
		$params['item'.$n]=$this->post->guid;
		$params['container'.($n+1)]=$this->related->type;
		$params['item'.($n+1)]=$this->related->guid;
		$r='';
		for($i=0;$i<=($n+1);$i++){
			$r.='container'.$i.'.';
		}
		$route=$r.$act;
		if($route=='container0.container1.container2.container3.show'){
			//echo '<h3>'.$route.'</h3>';
			//ddd(array_keys($params));
			return '1';
		}
		return route($route,$params);
		
			
	}

	public function getUrlAct($act){
		$params=\Route::current()->parameters();
		$routename=\Request::route()->getName();
		$routename_arr=explode('.',$routename);
		$routename_arr=array_slice($routename_arr,0,-1);
		$last=last($routename_arr);
		$second_last=collect(array_slice($routename_arr,-2))->first(); //penultimo
		if($last==null){
			return $this->getRouteN(0,$act);//.'#0';
		}
		$last_obj=$params[$last];
		$second_last_obj=$params[$second_last];
		$n=str_replace('container','',$last);
		if($second_last_obj->type==$this->post->type && $last_obj->type==$this->related->type){
			return $this->getRouteN($n-1,$act);//.'#1['.$n.']';			
		}

		if($last_obj->type!=$this->post->type){
			return $this->getRouteN($n+1,$act);//.'#2['.$n.']['.$second_last_obj->type.']['.$this->post->type.']';
		}

		return $this->getRouteN($n,$act);//.'#3['.$n.']';
	}

	public function getUrlAttribute($value){
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
	public function getStoreUrlAttribute($value){
		return $this->getUrlAct('store');
	}
	public function getIndexUrlAttribute($value){
		return $this->getUrlAct('index');
	}
	public function getCreateUrlAttribute($value){
		return $this->getUrlAct('create');
	}
	public function getDestroyUrlAttribute($value){
		return $this->getUrlAct('destroy');
	}
	public function getUpdateUrlAttribute($value){
		return $this->getUrlAct('update');
	}
	public function getShowUrlAttribute($value){
		return $this->getUrlAct('show');
	}
	public function getEditUrlAttribute($value){
		return $this->getUrlAct('edit');
	}
	//--------------------------------------------------
	public function getAttachUrlAttribute($value){
		return $this->getUrlAct('attach');
	}
	public function getDetachUrlAttribute($value){
		return $this->getUrlAct('detach');
	}
	public function getMovedownUrlAttribute($value){
		return $this->getUrlAct('movedown');
	}
	public function getMoveupUrlAttribute($value){
		return $this->getUrlAct('moveup');
	}
  

}
