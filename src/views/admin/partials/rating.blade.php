@php
	$options=array_keys(config('xra.model'));
	$options=array_combine($options,$options);
@endphp
{{ Form::bsSelect('related_type',null,['options'=>$options]) }}