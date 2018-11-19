<ul class="nav nav-tabs">
	<li>
		<a href="{{ route('blog.lang.container.container1.edit',$params) }}" class="btn">
			<i class="far fa-arrow-alt-circle-left"></i>
			Back
		</a>
	</li>
@foreach(config('xra.model') as $k => $v)
	@php
		$params['lang']=\App::getLocale();
		$params['container2']=$k;
	@endphp
	<li role="presentation">
		<a href="{{route('blog.lang.container.container1.container2.index',$params)}}">{{$k}}</a>
	</li>
@endforeach
</ul>