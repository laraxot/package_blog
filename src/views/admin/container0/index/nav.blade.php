<ul class="nav nav-tabs">
@foreach(config('xra.model') as $k => $v)
	@php
		$params['lang']=\App::getLocale();
		$params['container0']=$k;
	@endphp
	<li role="presentation" @if($container0->guid==$k) class="active" @endif>
		<a href="{{route('blog.container0.index',$params)}}">{{$k}}</a>
	</li>
@endforeach
@include('adm_theme::layouts.partials.lang')

</ul>