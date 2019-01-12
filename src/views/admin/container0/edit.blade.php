@extends('adm_theme::layouts.app')
@section('page_heading','Update '.$container0->title.' - '.$item0->title)
@include('backend::includes.components')
@section('content')
@include('backend::includes.flash')
<style>
.panel-title .fa {
  transition: .3s transform ease-in-out;
}
.panel-title .collapsed .fa {
  transform: rotate(90deg);
}
</style>
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
				{!! $row->linkedFormFields() !!}
				<hr style="clear:both" />
				{!! Form::bsTinymce('txt') !!}
				<br style="clear:both" /><br style="clear:both" />
				<fieldset>
					<legend>primary image</legend>
					{!! Form::bsUnisharpFileMan('image_src') !!}
					{{ Form::bsText('image_alt') }}
					{{ Form::bsText('image_title') }}
				</fieldset>
				{{--
				<fieldset>
					<legend>SEO</legend>
					{{ Form::bsText('guid') }}
					<div class="col-md-6">
					{{ Form::bsTextarea('meta_description') }}
					</div>
					<div class="col-md-6">
					{{ Form::bsTextarea('meta_keywords') }}
					</div>
					

				</fieldset>
				--}}

				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingTwo">
							<h4 class="panel-title">
								<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
									<i class="fa fa-chevron-down pull-right"></i>
									SEO
								</a>
							</h4>
						</div>
						<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
							<div class="panel-body">
								{{ Form::bsText('guid') }}
								{{ Form::bsTextarea('meta_description') }}
								{{ Form::bsTextarea('meta_keywords') }}
							</div>
						</div>
					</div>
				</div>


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