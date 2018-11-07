@extends('adm_theme::layouts.app')
@section('page_heading','Modifica '.$container0->title.' - '.$item->title)
@include('backend::includes.components')
@section('content')
@include('backend::includes.flash')
<div class="row">
	<div class="col-md-12">
		<div class="nav-tabs-custom">
			@include($view.'.nav')
			<div class="tab-content">
				{!! Form::bsOpen($row,'update') !!}
				{{ Form::bsText('title') }}
				{{ Form::bsText('subtitle') }}
				{!! $row->linkedFormFields() !!}
				<hr style="clear:both" />
				{!! Form::bsTinymce('txt') !!}
				<br style="clear:both" /><br style="clear:both" />
				{{-- Form::bsText('author_id') --}} {{--  questo non e' upadted_by .. ma a quale autore e' assegnato l'articolo --}}
				{{-- Form::bsNumber('category_id') --}}
				{!! Form::bsUnisharpFileMan('image_src') !!}
				{{ Form::bsText('image_alt') }}
				{{ Form::bsText('image_title') }}
				{{ Form::bs3Submit('Salva e continua') }}
				{!! Form::close() !!}
				<br style="clear:both" />
			</div>
		</div>
	</div>
</div>
@endsection