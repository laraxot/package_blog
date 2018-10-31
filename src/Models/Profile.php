<?php

namespace XRA\Blog\Models;

use Illuminate\Database\Eloquent\Model;

//use Laravel\Scout\Searchable;

use Carbon\Carbon;
use XRA\Extend\Traits\Updater;
//--------- models --------
use XRA\Blog\Models\Post;
use XRA\LU\Models\User;

/**
 * { item_description }
 * da fare php artisan scout:import XRA\Blog\Models\Post
 *
 * @mixin \Eloquent
 */

class Profile extends Model{
	//use Searchable; //se non si crea prima indice da un sacco di errori
	use Updater;
	protected $table = "blog_post_profiles";
	protected $fillable = ['post_id','bio'];
	protected $appends=[];
	protected $dates=['created_at', 'updated_at'];
	protected $primaryKey = 'post_id';
	public $incrementing = false; 

	public function filter($params){
		$row = new self;
		return $row;
	}//end filter

	public function post(){
		return $this->belongsTo(Post::class,'post_id','post_id');
	}

	public function relatedType($type){
		return $this->post->related()->wherePivot('type', $type);//->where('lang',\App::getLocale());
	}

	public function formFields(){
		//$view=CrudTrait::getView(); //non posso usarla perche' restituisce la view del chiamante
		//return view('blog::admin.post.partials.'.strtolower(class_basename($this)) )->with('row',$this);
		return false;
	}

	public function sync(){
		$users=User::whereRaw('1=1');
		$lang=\App::getLocale();
		//dd($users->get());
		foreach($users->get() as $user){
			//echo '<br/>'.$user->handle;
			$row=Post::firstOrCreate(['guid'=>$user->handle,'lang'=>$lang,'type'=>'profile'],['title'=>'profile of '.$user->handle]);
		}
		//dd('['.__LINE__.']['.__FILE__.']');
		return ; //'aaa';
	}

}//end model
