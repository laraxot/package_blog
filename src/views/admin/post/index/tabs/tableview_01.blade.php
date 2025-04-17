
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
	<td>[{{ $row->id }}][{{ $row->post_id }}]</td>
	<td>
	{{ $row->title }}
	{{--  <small>{{ $row->guid }}</small> --}}
	</td>
	<td>{{ $row->post_type }}</td>
	<td>{{-- $row->image() --}}</td>
	<td>
		{!! Form::bsBtnEdit(['id_post'=>$row->id]) !!}
		{!! Form::bsBtnDelete(['id_post'=>$row->id]) !!}
	</td>
</tr>
@endforeach
</table>
{{ $rows->links() }}