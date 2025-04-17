<br style="clear:both" /><br style="clear:both" /><br style="clear:both" />
<fieldset>
	<legend>Geo</legend>
	{!! Form::bsText('latitude',$row->latitude) !!}
	{!! Form::bsText('longitude',$row->longitude) !!}
	{!! Form::bsText('address1',$row->address1) !!}
	{!! Form::bsText('address2',$row->address2) !!}
	{!! Form::bsText('address3',$row->address3) !!}
	{!! Form::bsText('city',$row->city) !!}
	{!! Form::bsText('zip_code',$row->zip_code) !!}
	{!! Form::bsText('country',$row->country) !!}
	{!! Form::bsText('state',$row->state) !!}
</fieldset>
<fieldset>
	<legend>Contatti</legend>
	{!! Form::bsText('phone',$row->phone) !!}
	{!! Form::bsText('display_phone',$row->display_phone) !!}
</fieldset>
<fieldset>
	<legend>Info</legend>
	{!! Form::bsText('price',$row->price) !!}
	{!! Form::bsText('is_closed',$row->is_closed) !!}
	{!! Form::bsText('review_count',$row->review_count) !!}
	{!! Form::bsText('yelp_url',$row->yelp_url) !!}
	{!! Form::bsText('rating',$row->rating) !!}
</fieldset>