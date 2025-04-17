@extends('adm_theme::layouts.app')
@section('page_heading',''.$container0->post_type.'] '.$container0->title.' &raquo; '.$container1->title)
@include('backend::includes.components')
@section('content')
@include('backend::includes.flash')

@include($view.'.nav')
{{--
<a href="{{ route('blog.lang.container.container1.editcontainer',$params) }}" class="btn btn-default"><i class="fa fa-edit"></i>&nbsp;Modifica Contenitore</a>
--}}
<h3>Records: {{ $rows->total() }} </h3>

<br/><br/>
<table class="table">
<thead>
	<tr>
		<th>ID</th>
		<td>Foto</td>
		<th>Titolo</th>
		<th>Tipo</th>
	</tr>
</thead>
@foreach($rows as $row)
<tr>
	<td>[{{ $row->id }}-{{ $row->post_id }}-{{$row->lang}}]</td>
	<td>{!! $row->image_html(['width'=>100,'height'=>100]) !!}<br/>
		{{ $row->image_title }}</td>
	<td>
	{{ $row->title }}
	{{--  <small>{{ $row->guid }}</small> --}}
	</td>
	<td>{{ $row->post_type }}</td>
	<td>{{-- $row->image() --}}</td>
	<td>
		
		{!! Form::bsBtnEdit(['item2'=>$row]) !!}
		{!! Form::bsBtnDelete(['item2'=>$row]) !!}
		<a class="btn btn-default" href="{{ $row->url }}"><i class="fa fa-eye"></i></a>
	</td>
</tr>
@endforeach
</table>
{{ $rows->links() }}
@endsection