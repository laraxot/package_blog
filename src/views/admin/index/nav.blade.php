<ul class="nav nav-tabs">
<li role="presentation" @if(Route::currentRouteName()=='blog.post.index') class="active" @endif>
  <a href="{{ route('blog.post.index',$params) }}">Table View</a>
</li>
<li role="presentation" @if(Route::currentRouteName()=='blog.post.tree.index') class="active" @endif >
	<a href="{{ route('blog.post.tree.index',$params) }}">Tree View</a>
</li>
@if(Route::currentRouteName()=='blog.post.type.list.index')
<li>{!! Form::bsBtnCreate() !!}</li>
@endif

{{-- lang --}}
{{ Theme::add('theme/bc/bootstrap-language/languages.min.css') }}
<li class="dropdown">
	<a class="dropdown-toggle" data-toggle="dropdown" href="#">
	<i class="lang-sm lang-lbl-full" lang="{{ App::getLocale() }}"></i> <i class="fa fa-caret-down"></i>
	</a>
  <ul class="dropdown-menu" >
	@foreach(config('laravellocalization.supportedLocales') as $lang => $vl)
			@if($lang!=App::getLocale())
				<li><a href="{{  Theme::route(['lang'=>$lang]) }}"><i class="lang-sm lang-lbl-full" lang="{{ $lang}}"></i></a></li>
			@endif
	@endforeach
  </ul>
</li>
{{-- /lang --}}

</ul>
<ul class="nav nav-tabs">
@foreach(config('xra.post.type') as $type)
<li @if(isset($params['type']) && $params['type']==$type) class="active" @endif><a href="{{ route('blog.post.type.list.index',array_merge($params,['type'=>$type]) ) }}">{{ $type }}</a></li>
@endforeach
</ul>