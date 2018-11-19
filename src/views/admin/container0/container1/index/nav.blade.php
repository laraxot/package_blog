<ul class="nav nav-tabs">
	<li>
		<a href="{{ route('blog.container0.edit',$params) }}" class="btn btn-default">
			<i class="far fa-arrow-alt-circle-left"></i>
			&laquo;Back
		</a>
	</li>
@foreach(config('xra.model') as $k => $v)
	@php
		//$params['lang']=\App::getLocale();
		$params['container1']=$k;
	@endphp
	<li role="presentation" @if($container1->guid==$k) class="active" @endif>
		<a href="{{ route('blog.container0.container1.index',$params) }}">{{$k}}</a>
	</li>
@endforeach

@include('adm_theme::layouts.partials.lang')
{!! Form::bsBtnCreate() !!}