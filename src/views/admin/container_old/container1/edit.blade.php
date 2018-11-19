@extends('adm_theme::layouts.app')
@section('page_heading','Modifica '.$container1->title.' &raquo; '.$item1->title)
@include('backend::includes.components')
@section('content')
@include('backend::includes.flash')

@include($view.'.nav')

@php
	//$row=$item;
@endphp

{!! Form::bsOpen($row,'update') !!}

{{ Form::bsText('title') }}
{{ Form::bsText('subtitle') }}


{!! $row->linked->formFields() !!}

{{-- 
Form::bsText('guid') 
--}}
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
{{ Form::bs3Submit('Salva e continua') }}
{!! Form::close() !!}
{{--  
<div id="msg" >MSG</div>
--}}




<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
@endsection