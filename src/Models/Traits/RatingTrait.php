<?php
namespace XRA\Blog\Models\Traits;

//use Laravel\Scout\Searchable;

//----- models------
use XRA\Blog\Models\Post;
use XRA\Blog\Models\PostRelatedPivot;
use XRA\Blog\Models\Rating;
use XRA\Blog\Models\RatingMorph;

//------ traits ---
use XRA\Extend\Services\ThemeService;

trait RatingTrait{

	//----- relationship -----

	 public function ratings(){
        $related=Rating::class;
        if(is_string($related)){
            $pivot=$related.'Morph';
        }else{
            $pivot=get_class($related).'Morph';
        }
        $name='post';
        $pivot_table=with(new $pivot)->getTable();
        $pivot_fields=with(new $pivot)->getFillable();
        //ddd($pivot_fields);
        $foreignPivotKey = 'post_id'; 
        $relatedPivotKey = 'related_id'; 
        $parentKey = 'post_id';
        $relatedKey = 'post_id'; 
        $inverse=false;
        //$related_table=with(new $related)->getTable();
        //return $this->morphRelated($related);
        ///*
        return $this->morphToMany($related, $name,$pivot_table, $foreignPivotKey,
                                $relatedPivotKey, $parentKey,
                                $relatedKey, $inverse)
                    ->withPivot($pivot_fields)
        ;
    }

    public function ratingObjectives(){
        $related=Rating::class;
        return $this->hasMany($related,'related_type','post_type');
    }

    public function myRatings(){
        $auth_user_id=\Auth::user()->auth_user_id;
        $rows=$this->ratings()->wherePivot('auth_user_id',$auth_user_id);
        return $rows;
    }
	//----- mutators -----

    public function getMyRatingAttribute($value){
        $my=$this->myRatings;
        return $my->pluck('pivot.rating','post_id');
    }

    public function setMyRatingAttribute($value){
        ddd($value);
    }


}