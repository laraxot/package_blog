<?php
namespace XRA\Blog\Models;

//use Illuminate\Database\Eloquent\Model;
//use Laravel\Scout\Searchable;

//use XRA\Blog\Models\Traits\LinkedTrait;
//use XRA\Extend\Traits\Updater;

//------services---------
use XRA\Extend\Services\ThemeService;
use XRA\Extend\Services\ImportService;

//------ models --------
use XRA\Blog\Models\Article;

class Place extends BaseModel{
	protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable = ['id','post_id','post_type',
    		//---- address_components----
    		'premise', 'locality', 'postal_town',  
            'administrative_area_level_3','administrative_area_level_2',  'administrative_area_level_1', 
             'country', 
             'street_number', 'route', 'postal_code', 
             'googleplace_url',
            'point_of_interest', 'political', 'campground',
            //----- 
            'latitude','longitude','formatted_address','nearest_street',
        ];

    public static $address_components = [
            'premise', 'locality', 'postal_town',  
            'administrative_area_level_3','administrative_area_level_2',  'administrative_area_level_1', 
             'country', 
             'street_number', 'route', 'postal_code', 
             'googleplace_url',
            'point_of_interest', 'political', 'campground',
        ];

    //----- mutators -----
        /*
    public function setLocalityAttribute($value){
        $address=$this->attributes['formatted_address'];
        $tmp=ImportService::getAddressFields(['address' => $address]);
        $this->attributes=array_merge($this->attributes,$tmp);
    }
    */
    public function setFormattedAddressAttribute($value){
        //ddd($value);

        if(isset($this->attributes['formatted_address'])){
            $address=$this->attributes['formatted_address'];
        }else{
            $address=$value;
            $this->attributes['formatted_address']=$value;
        }
        if($address!=''){
            $tmp=ImportService::getAddressFields(['address' => $address]);
            $this->attributes=array_merge($this->attributes,$tmp);
            //ddd($this->attributes);
        }
        
    }
}