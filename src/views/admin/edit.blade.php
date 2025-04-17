@extends('adm_theme::layouts.app')
@section('page_heading','Modifica')
@include('backend::includes.components')
@section('content')
@include('backend::includes.flash')
@include('blog::admin.post.edit.nav')


{!! Form::bsOpen($row,'update') !!}

@if(isset($params['type']) &&  $params['type']!='')
{{-- 4 debug   --}}
@else
{{ Form::bsSelect('type',null,config('xra.post.type')) }}
@endif

{{ Form::bsText('title') }}
{{ Form::bsText('subtitle') }}
{!! $row->linkedFormFields() !!}

{{-- Form::bsText('guid') --}}

<hr style="clear:both" />

{{-- Form::bsGridStack('content', $row->PostContentJson()) --}}

{!! Form::bsTinymce('txt') !!}
<br style="clear:both" /><br style="clear:both" />
{{-- Form::bsText('author_id') --}} {{--  questo non e' upadted_by .. ma a quale autore e' assegnato l'articolo --}}
{{-- Form::bsNumber('category_id') --}}
{!! Form::bsUnisharpFileMan('image_src') !!}
{{ Form::bsText('image_alt') }}
{{ Form::bsText('image_title') }}




{{--
<div id='news' style="display:none">
	@include('blog::admin.post.partials.news')
</div>
<div id='section' style="display:none">
	@include('blog::admin.post.partials.section')
</div>
<div id='theme' style="display:none">
	@include('blog::admin.post.partials.theme')
</div>
--}}
{{ Form::bsSubmit('Salva e continua') }}
{!! Form::close() !!}
{{--  
<div id="msg" >MSG</div>
--}}




<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
@endsection

@push('scripts')
<script>
$('#type').on('change', function() {
	$('#news').hide();
	$('#section').hide();
	$('#theme').hide();
	$( "#"+this.value ).toggle( "slow", function() {
    // Animation complete.
  });
})
</script>
@endpush 

{{--
$('#myform').on('change', 'select', function (e) {
    var val = $(e.target).val();
    var text = $(e.target).find("option:selected").text(); //only time the find is required
    var name = $(e.target).attr('name');
}
--}}
