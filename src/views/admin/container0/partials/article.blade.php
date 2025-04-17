<br style="clear:both" /><br style="clear:both" /><br style="clear:both" />
<fieldset>
	<legend>Article info</legend>
	{!! Form::bsText('linked[article_type]') !!}
	{!! Form::bsDateTimeLocal('linked[published_at]') !!} 
	{{-- ddd($articleCat->archive()->pluck('title','post_id')) --}}
	{!! Form::bsSelect('related[articleCat]',null,$articleCat->archive()->pluck('title','post_id')) !!}
</fieldset>