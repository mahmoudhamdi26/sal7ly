<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model {
	protected $primaryKey = 'id'; // or null
//    public $incrementing = false;

	var $table = 'countries';

	var $fillable = [ 'id', 'name', 'abbreviation', 'stats_id', 'name_ar' ];

	var $hidden = [ 'created_at', 'updated_at' ];

	var $dates = [ 'created_at', 'updated_at' ];

	protected $dateFormat = 'Y-m-d H:i:s';

	public function featured_leagues() {
		return $this->belongsToMany( 'App\models\League', 'countries_leagues',
			'country_id', 'league_id' )
		            ->withPivot( [ 'is_primary', 'order' ] )
		            ->with( [ 'country' ] )
		            ->where( 'is_active', true )
		            ->orderBy( 'order_num' )
		            ->orderBy( 'name' );
	}
}
