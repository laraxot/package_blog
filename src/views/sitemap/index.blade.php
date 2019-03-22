<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
   	
   	@foreach($roots as $row)   <sitemap>
      <loc>{{ url($lang.'/sitemap/'.$row->guid) }}{{-- $row->url --}}</loc>
      <lastmod>{{ $row->updated_at }}</lastmod>
   </sitemap>
   @endforeach
</sitemapindex>