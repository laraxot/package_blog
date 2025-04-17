@extends('adm_theme::layouts.app')
@section('page_heading',''.$container0->title.' - '.$item0->title)
@include('backend::includes.components')
@section('content')
@include('backend::includes.flash')
<div class="row">
	<div class="col-md-10">
		<div class="nav-tabs-custom">
			@include($view.'.nav')
			<div class="tab-content">
				lo show must go on 
			</div>
		</div>
	</div>
	<div class="col-md-2">
		<span>
		created_at {{ $row->created_at }}<br/>
		updated_at {{ $row->updated_at }}<br/>
		</span>
	</div>
</div>

@endsection