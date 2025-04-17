{{--
<br style="clear:both" /><br style="clear:both" /><br style="clear:both" />
<fieldset>
	<legend>Article info</legend>
	{!! Form::bsText('linked[article_type]') !!}
	{!! Form::bsDateTimeLocal('linked[published_at]') !!}
	@php
		$val=$row->relatedrevType('articleCat')->first();
		if($val!=null){
			$val=$val->post_id;
		}
	@endphp
	[{{ $row->relatedrevType('articleCat')->count() }}]

	{!! Form::bsSelect('relatedrev[articleCat]',$val,$articleCat->options()) !!}
</fieldset>
http://hellofrancesco.com/articoli/laravel-cafe-1-eloquent-relazioni-ed-eventi
--}}

