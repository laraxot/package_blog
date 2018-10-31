@extends('adm_theme::layouts.app')
@section('page_heading','Modifica SEO '.$container->title.' &raquo; '.$item->title)
@include('backend::includes.components')
@section('content')
@include('backend::includes.flash')
<div class="row">
	<div class="col-md-12">
		<div class="nav-tabs-custom">
			@include($view.'.nav')
			<div class="tab-content">
				{!! Form::bsOpen($row,'update') !!}
				{{ Form::bsText('guid') }}
				{{ Form::bsTextarea('meta_description') }}
				{{ Form::bsTextarea('meta_keywords') }}
				{{ Form::bsChips('tags') }}
				{{ Form::bs3Submit('Salva e continua') }}
				{!! Form::close() !!}
				{{--  
				<div id="msg" >MSG</div>
				<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
				--}}
				<br style="clear:both" />
			</div>
		</div>
	</div>
</div>
@endsection