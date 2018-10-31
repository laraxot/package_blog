@extends('adm_theme::layouts.app')
@section('page_heading','Contenuti')
@include('backend::includes.components')
@section('content')
@include('backend::includes.flash')
@include('blog::admin.post.index.nav')
<br/><br/>
 {{-- Theme::tabs(['row'=>[],'view'=>'blog::admin.post.index','rows'=>$rows,'allrows'=>$allrows]) --}}
@if(Route::currentRouteName()=='blog.post.type.list.index')
 <table class="table">
<thead>
	<tr>
		<th>ID</th>
		<th>Titolo</th>
		<th>Tipo</th>
	</tr>
</thead>
@foreach($rows as $row)
<tr>
	<td>[{{ $row->id }}-{{ $row->post_id }}]</td>
	<td>
	{{ $row->title }}
	{{--  <small>{{ $row->guid }}</small> --}}
	</td>
	<td>{{ $row->type }}</td>
	<td>{{-- $row->image() --}}</td>
	<td>
		{!! Form::bsBtnCrud(['id_post'=>$row->id]) !!}
		<a class="btn btn-default" href="{{ $row->url }}"><i class="fa fa-eye"></i></a>
	</td>
</tr>
@endforeach
</table>
{{ $rows->links() }}
@endif
@endsection