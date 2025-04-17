<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
  xmlns:xhtml="http://www.w3.org/1999/xhtml">
	<url>
	  <loc>{{ url('/') }}</loc>
	  <lastmod>{{ \Carbon\Carbon::now()->format('Y-m-d') }}</lastmod>
	  <changefreq>weekly</changefreq>
	  <priority>0.8</priority>
   </url>
   <url>
	  <loc>{{ $root->url }}</loc>
		@foreach (config('laravellocalization.supportedLocales') as $k=>$lang)
		<xhtml:link  
				 rel="alternate"
				 hreflang="{{ $k }}"
				 href="{{ $root->urlLang($k) }}"
				 />
		@endforeach
		@if($root->updated_at)
		<lastmod>{{ $root->updated_at->format('Y-m-d') }}</lastmod>
		@endif
		<changefreq>weekly</changefreq>
   </url>
{{--  
@foreach($root->archive()->paginate(50) as $row)
--}}
@foreach($rows as $row)
	<url>
	  <loc>{{ $row->url }}</loc>
		@foreach (config('laravellocalization.supportedLocales') as $k=>$lang)
		<xhtml:link  
				 rel="alternate"
				 hreflang="{{ $k }}"
				 href="{{ $row->urlLang($k) }}"
				 />
		@endforeach
		@if($row->updated_at)
		<lastmod>{{ $row->updated_at->format('Y-m-d') }}</lastmod>
		@endif
		<changefreq>weekly</changefreq>
   </url>
{{--
@foreach($row->archive()->get() as $son)   
	<url>
	  <loc>{{ $son->url }}</loc>
	  @foreach (config('laravellocalization.supportedLocales') as $k=>$lang)
		<xhtml:link  
				 rel="alternate"
				 hreflang="{{ $k }}"
				 href="{{ $son->urlLang($k) }}"
				 />
		@endforeach
	  @if($son->updated_at)
	  <lastmod>{{ $son->updated_at->format('Y-m-d') }}</lastmod>
	  @endif
	  <changefreq>weekly</changefreq>
	</url>
@endforeach
--}}
@endforeach
</urlset> 