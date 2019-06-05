<ul class="nav nav-tabs">
@foreach(config('xra.model') as $k => $v)
	@php
		$params['lang']=\App::getLocale();
		$params['container0']=$k;
	@endphp
	<li class="nav-item {{ $container0->guid==$k?'active':'' }}" role="presentation" >
		<a class="nav-link {{ $container0->guid==$k?'active':'' }}" href="{{route('blog.container0.index',$params)}}">{{$k}}</a>
	</li>
@endforeach
@include('adm_theme::layouts.partials.lang')

</ul>