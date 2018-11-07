<ul class="nav nav-tabs">
	<li role="presentation">
		<a href="{{ route('blog.lang.container.index',$params) }}" title="back">&laquo;</a>
	</li>
	<li role="presentation" class="active">
		<a href="#">Contenuto</a>
	</li>
	<li role="presentation">
		<a href="#">Seo</a>
	</li>
	<li role="presentation">
		<a href="#">Related</a>
	</li>
	<li role="presentation">
		<a href="#">RelatedRev</a>
	</li>
	@include('adm_theme::layouts.partials.dropdowns.lang')
</ul>