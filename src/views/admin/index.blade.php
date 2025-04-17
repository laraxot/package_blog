@extends('adm_theme::layouts.app')
@section('page_heading','Blog')
@section('content')
@include('backend::includes.flash')
@include('backend::includes.components')


<ul class="nav nav-tabs">
@foreach(config('xra.model') as $k => $v)
	@php
		$params['lang']=\App::getLocale();
		$params['container']=$k;
	@endphp
	<li class="nav-item" role="presentation">
		<a class="nav-link" href="{{route('blog.container0.index',$params)}}">{{$k}}</a>
	</li>
@endforeach
</ul>

@endsection