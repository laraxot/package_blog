@extends('adm_theme::layouts.app')
@section('page_heading',''.$container0->type.'] '.$container0->title.' - '.$container1->title)
@include('backend::includes.components')
@section('content')
@include('backend::includes.flash')

@include($view.'.nav')
{{ $row->title }}

<h3>Records: {{ $rows->total() }} </h3>

<br/><br/>
<table class="table">
<thead>
	<tr>
		<th>ID</th>
		<td>Foto</td>
		<th>Titolo</th>
		<th>Tipo</th>
		<td></td>
	</tr>
</thead>
@foreach($rows as $row)
<tr>
	<td>[{{ $row->id }}-{{ $row->post_id }}-{{$row->lang}}]</td>
	<td>{!! $row->image_html(['width'=>100,'height'=>100]) !!}<br/>
		{{ $row->image_title }}</td>
	<td>
	{{ $row->title }}<br/>
	<small>{{ $row->guid }}</small>
	</td>
	<td>{{ $row->type }}</td>
	
	<td>
		
		{!! Form::bsBtnEdit(['item1'=>$row]) !!}
		{!! Form::bsBtnDelete(['item1'=>$row]) !!}
		<a class="btn btn-default" href="{{ $row->url }}"><i class="fa fa-eye"></i></a>
	</td>
</tr>
@endforeach
</table>
{{ $rows->links() }}
@endsection