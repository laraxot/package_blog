@extends('adm_theme::layouts.app')
@section('page_heading',''.$container->type.'] '.$container->title.' &raquo; '.$container1->title)
@include('backend::includes.components')
@section('content')
@include('backend::includes.flash')

  show 1
@endsection