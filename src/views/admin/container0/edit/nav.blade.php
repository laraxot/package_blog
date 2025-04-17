<ul class="nav nav-tabs">
	<li role="presentation" class="nav-item" >
		<a class="nav-link" href="{{ route('blog.container0.index',$params) }}">&laquo;start</a>
	</li>
	{{--  
	@foreach($params as $p)
	@if(is_object($p))
	<li role="presentation">
		<a href="{{ $p->index_url }}" title="back">{{ $p->title }}</a>
	</li>
	@endif
	@endforeach
	--}}
	<li role="presentation"  class="nav-item" >
		<a class="nav-link"  href="{{ $row->index_url }}" title="back">&laquo;</a>
	</li>
	<li role="presentation" class="nav-item active">
		<a class="nav-link active" href="{{ $row->edit_url }}">Contenuto</a>
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
	@php
		$related=array_keys(config('xra.model'));
		$tmp=config('xra.related.'.$row->post_type);
		if(is_array($tmp)){
			$related=$tmp;
		}
	@endphp
	@foreach($related as $k => $v)
	@php
		$params['container1']=$v;
	@endphp
	<li role="presentation" class="nav-item" >
		<a  class="nav-link" href="{{ route('blog.container0.container1.index',$params) }}">Related {{studly_case($v)}}</a>
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