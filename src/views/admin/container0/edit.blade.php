@extends('adm_theme::layouts.app')
@section('page_heading','Update '.$container0->title.' - '.$item0->title)
@include('backend::includes.components')
@section('content')
@include('backend::includes.flash')
<div class="row">
	<div class="col-md-10">
		<div class="nav-tabs-custom">
			@include($view.'.nav')
			<div class="tab-content">
				{!! Form::bsOpen($row,'update') !!}
				
				{{ Form::bsText('title') }}
				<div class="form-group">
					<label for="title" class="col-md-4 control-label">Url:</label>
					<div class="col-md-6">	
						{{ $row->url }}
					</div>
				</div>
				<br style="clear:both" />
				{{ Form::bsText('subtitle') }}
				{{--
				@include(str_replace('.edit','.partials.'.$row->type,$view))
				@include('blog::admin.partials.'.snake_case($row->type))
				dobbiamo usare funzione perche' potrebbe essere esterno
				--}}
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
	<div class="col-md-2">
		<span>
		created_at {{ $row->created_at }}<br/>
		updated_at {{ $row->updated_at }}<br/>
		</span>
	</div>
</div>
@endsection