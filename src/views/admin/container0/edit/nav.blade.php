<ul class="nav nav-tabs">
	<li role="presentation">
		<a href="{{ route('blog.container0.index',$params) }}" title="back">&laquo;</a>
	</li>
	<li role="presentation" class="active">
		<a href="#">Contenuto</a>
	</li>
	<li role="presentation">
		{{--
		<a href="{{ route('blog.container0.editseo',$params)}}">Seo</a>
		--}}
	</li>

	<li role="presentation">
		{{--
		<a href="{{ route('blog.container0.related.index',$params) }}">Related</a>
		--}}
	</li>
	@foreach(config('xra.model') as $k => $v)
	@php
		$params['container1']=$k;
	@endphp
	<li role="presentation" >
		<a href="{{ route('blog.container0.container1.index',$params) }}">{{$k}}</a>
	</li>
	@endforeach
	{{--
	<li role="presentation">
		<a href="{{ route('blog.lang.container.relatedrev.index',$params) }}">RelatedRev</a>
	</li>
	--}}
	{{-- lang --}}
	@include('adm_theme::layouts.partials.lang')
</ul>