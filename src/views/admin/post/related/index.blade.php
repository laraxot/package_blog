@extends('adm_theme::layouts.app')
@section('page_heading','Related of Post')
@include('backend::includes.components')
@section('content')
@include('backend::includes.flash')
@include('blog::admin.post.edit.nav')
<br style="clear:both" />
{!! Form::bsBtnCreate() !!}
<a class="btn btn-xs btn-info" href="{{ route('blog.post.related.attach',$params) }}" data-toggle="tooltip" title="Collega Photo"><i class="fa fa-link fa-fw" aria-hidden="true"></i>Collega esistente</a>[{{ config('xra.primary_lang') }}]
{{-- $allrows->get() --}}
<table class="table">
<thead>
	<tr>
		<th>[ID][POST_ID]</th>
		<th>parent_id</th>
		<th>pos</th>
		<th>related type</th>
		<th>Titolo</th>
		<th>Tipo</th>
	</tr>
</thead>
@foreach($allrows->get() as $row)
<tr>
	<td>[{{ $row->id }}][{{ $row->post_id }}]</td>
	<td>{{ $row->parent_id }}</td>
	<td>{{ $row->pivot->pos}}</td>
	<td>{{ $row->pivot->type}}</td>
	<td>
	{{ $row->title }}
	{{--  <small>{{ $row->guid }}</small> --}}
	</td>
	<td>{{ $row->type }}</td>
	<td>{{-- $row->image() --}}</td>
	<td>
		{!! Form::bsBtnCrud(['id_photo'=>$row->id]) !!}
		@php
			$parz=$params;
			$parz['id_related']=$row->post_id;
			$url=route('blog.post.related.deattach',$parz);
		@endphp
		<a class="btn btn-small btn-warning" href="{{ $url }}" data-toggle="tooltip" title="Scollega"><i class="fa fa-unlink fa-fw" aria-hidden="true"></i></a>
	</td>
</tr>
@endforeach
</table>
{{-- $rows->links() --}}
@endsection