@extends('adm_theme::layouts.app')
@section('page_heading','Modifica Seo Articolo')
@include('backend::includes.components')
@section('content')

@include('blog::admin.post.edit.nav')


{!!  Form::bsOpen($row,'update') !!}

{{ Form::bsText('guid') }}
{{ Form::bsTextarea('meta_description') }}
{{ Form::bsTextarea('meta_keywords') }}
{{ Form::bsChips('tags') }}



{{ Form::bsSubmit('Salva ed esci') }}
{!! Form::close() !!}
<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
@endsection
