@extends('adm_theme::layouts.app')
@section('page_heading',''.$container->type.'] '.$container->title)
@include('backend::includes.components')
@section('content')
@include('backend::includes.flash')

@include($view.'.nav')


<a href="{{ route('blog.lang.container.editcontainer',$params) }}" class="btn btn-default">
	<i class="fa fa-edit"></i>&nbsp;Modifica Contenitore
</a>
<a class="btn btn-default" href="?syncSons" title="sincronizza figli">
	<i class="fa fa-refresh"></i>&nbsp;sincronizza figli
</a>

{!! Form::bsFormSearch() !!}
@php
	$rows=$container->archive()->paginate(20);
@endphp
<h3>Records: {{ $rows->total() }} </h3>

<br/><br/>
<table class="table table-striped table-hover table-bordered table-condensed">
<thead>
	<tr>
		<th>ID</th>
		<th>Foto</th>
		<th>Titolo/Sottotitolo</th>
		<th>Tipo</th>
		<th></th>
	</tr>
</thead>
@foreach($rows as $row)
<tr>
	<td>
		ID:{{ $row->id }}<br/>
		POST_ID:{{ $row->post_id }}<br/>
		LANG:{{$row->lang}}<br/>
		GUID:{{ $row->guid }}
	</td>
	<td>{!! $row->image_html(['width'=>100,'height'=>100]) !!}<br/>
		{{ $row->image_title }}</td>
	<td>
	{{ $row->title }}<hr/>
	{{ $row->subtitle }}
	</td>
	<td>{{ $row->type }}</td>
	<td>
		{{--
		{!! Form::bsBtnEdit(['item'=>$row]) !!}
		{!! Form::bsBtnDelete(['item'=>$row]) !!}
		<a class="btn btn-default" href="{{ $row->url }}"><i class="fa fa-eye"></i></a>
		--}}
	</td>
</tr>
@endforeach
</table>
{{ $rows->links() }}
@endsection