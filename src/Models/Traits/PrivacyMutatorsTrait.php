<?php
////////////////////////////////////////////////
//
//	QUESTO E' IL GENERICO, per food va usato quello dentro XRA\Food\Models\Traits;
//
/////////////////////////////////////////////////

namespace XRA\Blog\Models\Traits;

use Illuminate\Database\Eloquent\Model;

//use Laravel\Scout\Searchable;

use Carbon\Carbon;
use XRA\Extend\Traits\Updater;
//----- models------
use XRA\Blog\Models\Post;
use XRA\Blog\Models\PostRelatedPivot;


//------ traits ---
use XRA\Extend\Services\ThemeService;

/*
	protected $fillable = [
        'prvFlag_0', 'prvFlag_1', 'prvFlag_2', 'prvFlag_3', 'prvFlag_0Descr', 'prvFlag_1Descr', 'prvFlag_2Descr', 'prvFlag_3Descr'// qui per il set

    ];
    protected $appends = [
    	'prvFlag_0', 'prvFlag_1', 'prvFlag_2', 'prvFlag_3', 'prvFlag_0Descr', 'prvFlag_1Descr', 'prvFlag_2Descr', 'prvFlag_3Descr' // qui per il get
    ];
*/


trait PrivacyMutatorsTrait
{
    public function privacy()
    {
        return $this->hasMany(ProfilePrivacy::class, 'auth_user_id', 'auth_user_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'auth_user_id', 'auth_user_id');
    }
    public function getPrvFlagX($k)
    {

        //$row = ProfilePrivacy::firstOrCreate(['auth_user_id' => $this->auth_user_id, 'flag_id' => $k]);

        $row = ProfilePrivacy::where("flag_id", "=", $k)
            ->where("auth_user_id", $this->auth_user_id)
            ->latest()
            ->first();

        if ($row == null) {
            $row = ProfilePrivacy::create(['auth_user_id' => $this->auth_user_id, 'flag_id' => $k]);
        }
        $ris = $row->flag_value;

        //$row=$this->privacy()->firstOrCreate(['flag_id'=>$k]);
        return $ris;
    }

    public function setPrvFlagX($k, $v)
    {
        // @Marco valuta tu se mantenere lo storico, in questo caso decommenta questa e commenta l'altra
        //$row = ProfilePrivacy::firstOrCreate(['auth_user_id' => $this->auth_user_id, 'flag_id' => $k]);
        $row = ProfilePrivacy::create(['auth_user_id' => $this->auth_user_id, 'flag_id' => $k]);
        $row->update(['flag_value' => $v, 'field_description' => $this->getPrvFlagDescrX($k)]);
        //return $row->flag_value;
    }

    public function getPrvFlagDescrX($k)
    {
        return $this->desc[$k];
    }

    public function getPrvFlag0Attribute($value)
    {
        return $this->getPrvFlagX(0);
    }

    public function getPrvFlag1Attribute($value)
    {
        return $this->getPrvFlagX(1);
    }

    public function getPrvFlag2Attribute($value)
    {
        return $this->getPrvFlagX(2);
    }

    public function getPrvFlag3Attribute($value)
    {
        return $this->getPrvFlagX(3);
    }

    public function getPrvFlag0DescrAttribute($value)
    {
        return $value;
    }

    /*
     * Se memorizzo l'attributo nell'array $this->>attributes, poi vuole i campi sulla tabella...
     */
    public function setPrvFlag0DescrAttribute($value)
    {
        $this->desc[0] = $value;
    }

    public function getPrvFlag1DescrAttribute($value)
    {
        return $value;
    }

    /*
     * Se memorizzo l'attributo nell'array $this->>attributes, poi vuole i campi sulla tabella...
     */
    public function setPrvFlag1DescrAttribute($value)
    {
        $this->desc[1] = $value;
    }

    public function getPrvFlag2DescrAttribute($value)
    {
        return $value;
    }

    /*
     * Se memorizzo l'attributo nell'array $this->>attributes, poi vuole i campi sulla tabella...
     */
    public function setPrvFlag2DescrAttribute($value)
    {
        $this->desc[2] = $value;
    }

    public function getPrvFlag3DescrAttribute($value)
    {
        return $value;
    }

    /*
     * Se memorizzo l'attributo nell'array $this->>attributes, poi vuole i campi sulla tabella...
     */
    public function setPrvFlag3DescrAttribute($value)
    {
        $this->desc[3] = $value;
    }

    public function setPrvFlag0Attribute($value)
    {
        $this->setPrvFlagX(0, $value);
    }

    public function setPrvFlag1Attribute($value)
    {
        $this->setPrvFlagX(1, $value);
    }

    public function setPrvFlag2Attribute($value)
    {
        $this->setPrvFlagX(2, $value);
    }

    public function setPrvFlag3Attribute($value)
    {
        $this->setPrvFlagX(3, $value);
    }


}