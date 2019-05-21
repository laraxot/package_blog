<?php
namespace XRA\Blog\Models;

//use Illuminate\Database\Eloquent\Model;
//use Laravel\Scout\Searchable;

//use XRA\Blog\Models\Traits\LinkedTrait;
//use XRA\Extend\Traits\Updater;

//------services---------
use XRA\Extend\Services\ThemeService;
//------ models --------
use XRA\Blog\Models\Article;

class Place extends BaseModel{
	protected $primaryKey = 'post_id';
    public $incrementing = true;
    protected $fillable = ['post_id',
    		//---- address_components----
    		'premise', 'locality', 'postal_town',  
            'administrative_area_level_3','administrative_area_level_2',  'administrative_area_level_1', 
             'country', 
             'street_number', 'route', 'postal_code', 
             'googleplace_url',
            'point_of_interest', 'political', 'campground',
        ];

    public static $address_components = [
            'premise', 'locality', 'postal_town',  
            'administrative_area_level_3','administrative_area_level_2',  'administrative_area_level_1', 
             'country', 
             'street_number', 'route', 'postal_code', 
             'googleplace_url',
            'point_of_interest', 'political', 'campground',
        ];
}