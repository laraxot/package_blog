@extends('adm_theme::layouts.app')
{{ Theme::add('blog::admin/post/order/css/design.css') }}
{{ Theme::add('blog::admin/post/order/css/jquerysctipttop.css') }}
{{ Theme::add('theme/bc/jquery/dist/jquery.min.js') }}
{{ Theme::add('theme/bc/jquery-ui/themes/smoothness/jquery-ui.css') }}
{{ Theme::add('theme/bc/jquery-ui/jquery-ui.min.js') }}
{{ Theme::add('blog::admin/post/order/js/responder.js') }}
@section('content')
<ul class='space first-space' id='space0'>
	@foreach($allrows->ofParent(0)->get() as $row)
        @include('blog::admin.post.order.partials.item0',['row'=>$row])
	@endforeach
</ul>
{{--
	<li class='route'>
		<h3 class='title' id='title1'>A</h3>
		<span class='ui-icon ui-icon-arrow-4-diag'></span>
		<ul class='space' id='space1'>
		</ul>
	</li>
	<li class='route'>
		<h3 class='title' id='title2'>B</h3>
		<span class='ui-icon ui-icon-arrow-4-diag'></span>
		<ul class='space' id='space2'>
			<li class='route'>
				<h3 class='title' id='title3'>C</h3>
				<span class='ui-icon ui-icon-arrow-4-diag'></span>
				<ul class='space' id='space3'>
				</ul>
			</li>
		</ul>
	</li>
	<li class='route'>
		<h3 class='title' id='title4'>D</h3>
		<span class='ui-icon ui-icon-arrow-4-diag'></span>
		<ul class='space' id='space4'>
		</ul>
	</li>
	<li class='route'>
		<h3 class='title'>E</h3>
		<span class='ui-icon ui-icon-arrow-4-diag'></span>
		<ul class='space'>
		</ul>
	</li>
	<li class='route'>
		<h3 class='title'>F</h3>
		<span class='ui-icon ui-icon-arrow-4-diag'></span>
		<ul class='space'>
		</ul>
	</li>
	<li class='route'>
		<h3 class='title'>G</h3>
		<span class='ui-icon ui-icon-arrow-4-diag'></span>
		<ul class='space'>
		</ul>
	</li>
	<li class='route'>
		<h3 class='title'>H</h3>
		<span class='ui-icon ui-icon-arrow-4-diag'></span>
		<ul class='space'>
		</ul>
	</li>
</ul>
--}}
@endsection