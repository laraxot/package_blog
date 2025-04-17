<ul class="nav nav-tabs">

<li role="presentation" @if(Route::currentRouteName()=='blog.post.type.list.index') class="active" @endif>
  <a href="{{ route('blog.post.type.list.index',$params) }}"><i class="glyphicon glyphicon-triangle-left" aria-hidden="true"></i></a>
</li>
<li role="presentation" @if(Route::currentRouteName()=='blog.post.type.list.edit') class="active" @endif >
  	<a href="{{ route('blog.post.type.list.edit',$params) }}">Contenuto</a>
</li>
<li role="presentation" @if(Route::currentRouteName()=='blog.post.type.seo.edit') class="active" @endif>
  	<a href="{{ route('blog.post.type.seo.edit',$params) }}">Seo</a>
</li>
{{-- le foto sono in related  magari troviamo metodo per mostrarle meglio
<li role="presentation" @if(Route::currentRouteName()=='blog.post.photo.index') class="active" @endif>
    <a href="{{ route('blog.post.photo.index',$params) }}">Photos</a>
</li>
--}}
<li role="presentation" @if(Route::currentRouteName()=='blog.post.type.related.index') class="active" @endif>
    <a href="{{ route('blog.post.type.related.index',$params) }}">Related</a>
</li>
<li role="presentation" @if(Route::currentRouteName()=='blog.post.type.relatedrev.index') class="active" @endif>
    <a href="{{ route('blog.post.type.relatedrev.index',$params) }}">Related Reverse</a>
</li>
<li role="presentation" @if(Route::currentRouteName()=='blog.post.type.son.index') class="active" @endif>
    <a href="{{ route('blog.post.type.son.index',$params) }}">Sons</a>
</li>
{{-- --}}


{{--
@foreach(config('laravellocalization.supportedLocales') as $lang => $vl)
<li role="presentation" @if(App::getLocale()==$lang) class="active" @endif>
  	<a href="{{ $row->url_edit($lang) }}">{{ $lang }}</a>
</li>
@endforeach
<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
    <i class="fa fa-flag fa-fw"></i>   {{ App::getLocale() }} <i class="fa fa-caret-down"></i>
    </a>
    <ul class="dropdown-menu">
    	@foreach(config('laravellocalization.supportedLocales') as $lang => $vl)
    		@if($lang!=App::getLocale())
        		<li><a href="{{ $row->url_edit($lang) }}"><i class="fa fa-flag fa-fw"></i>{{ $lang }}</a></li>
        	@endif
        @endforeach
    </ul>
</li>
--}}

<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
    <i class="lang-sm lang-lbl-full" lang="{{ App::getLocale() }}"></i> <i class="fa fa-caret-down"></i>
    </a>
  <ul class="dropdown-menu" >
    @foreach(config('laravellocalization.supportedLocales') as $lang => $vl)
    		@if($lang!=App::getLocale())
        		<li><a href="{{ $row->url_edit($lang) }}"><i class="lang-sm lang-lbl-full" lang="{{ $lang}}"></i></a></li>
        	@endif
    @endforeach
  </ul>
</li>

</ul>
{{ Theme::add('theme/bc/bootstrap-language/languages.min.css') }}
