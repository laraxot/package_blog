@extends('adm_theme::layouts.app')
@section('page_heading',''.$container0->type.'] '.$container0->title.'  Related')
@include('backend::includes.components')
@section('content')
@include('backend::includes.flash')

@include($view.'.nav')

{!! Form::bsBtnCreate() !!}

<a class="btn btn-default" href="{{ route('blog.lang.container.related.attach',$params) }}" data-toggle="tooltip" title="Collega Esistente"><i class="fa fa-link fa-fw" aria-hidden="true"></i>Collega esistente</a>[{{ config('xra.primary_lang') }}]

@php
	$rows=$row->related;
@endphp 

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
@foreach($rows as $row)
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
		
		
		@php
			$parz=$params;
			$parz['related']=$row;
			$url=route('blog.lang.container.related.deattach',$parz);
		@endphp

		<a class="btn btn-warning" href="{{ $url }}" data-toggle="tooltip" title="Scollega"><i class="fa fa-unlink fa-fw" aria-hidden="true"></i></a>
		<a class="btn btn-default" href="{{ $row->type }}">test</a>
		
	</td>
</tr>
@endforeach
</table>

@endsection

