<ul class="nav nav-tabs">
	<li role="presentation">
		<a href="{{ route('blog.container0.index',$params) }}" title="back">&laquo;</a>
	</li>
	<li role="presentation">
		<a href="{{ route('blog.container0.edit',$params) }}">Content</a>
	</li>
	{{--
	<li role="presentation">
		<a href="#">Seo</a>
	</li>
	--}}
	@foreach(config('xra.model') as $k => $v)
	<li role="presentation" {!! ($k==$container1->guid)?' class="active"':'' !!}>
		<a href="{{ route('blog.container0.container1.index',array_merge($params,['container1',$k])) }}">
			related {{ str_plural($k) }}
		</a>
	</li>
	@endforeach
	{{-- lang --}}
	@include('adm_theme::layouts.partials.lang')
</ul>