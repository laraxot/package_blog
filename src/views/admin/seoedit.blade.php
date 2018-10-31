@extends('adm_theme::layouts.app')
@section('page_heading','Modifica Seo Articolo')
@include('backend::includes.components')
@section('content')

@include('blog::admin.post.nav')

{!!  Form::bsOpen($row,'update') !!}

{{ Form::bsText('guid') }}
{{ Form::bsText('meta_description') }}
{{ Form::bsText('meta_keywords') }}


{{ Form::bsSubmit('Salva ed esci') }}
{!! Form::close() !!}
<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
@endsection
