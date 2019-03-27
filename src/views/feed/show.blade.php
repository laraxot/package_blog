<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
	>

<channel>
	<title>{{ Theme::metatag('title') }} </title>
	<atom:link href="{{ Request::url() }}" rel="self" type="application/rss+xml" />
	<link>{{ Theme::metatag('url') }}</link>
	<description>{{ Theme::metatag('meta_description') }}</description>
	<lastBuildDate>{{-- Mon, 12 Feb 2018 08:04:16 +0000 --}}{{ \Carbon\Carbon::now()->format('D, d M Y H:i:s T') }}</lastBuildDate>
	<language>{{ Theme::metatag('language') }}{{-- $locale['regional'] --}}</language>
	<sy:updatePeriod>hourly</sy:updatePeriod>
	<sy:updateFrequency>1</sy:updateFrequency>
	<generator>xot</generator>

	<atom:link rel="hub" href="https://pubsubhubbub.appspot.com"/>
	<atom:link rel="hub" href="https://pubsubhubbub.superfeedr.com"/>	
	@foreach($rows as $row)
	<item>
		<title>{{ $row->title}}</title>
		<link>{{ $row->url }}</link>
		<pubDate>{{ $row->updated_at->format('D, d M Y H:i:s T') }}</pubDate>
		{{-- <dc:creator><![CDATA[Andrea Izzo]]></dc:creator> --}}
		<category><![CDATA[{{ $row->post_type }}]]></category>
		<guid isPermaLink="false">{{ $row->url }}</guid>
		<description><![CDATA[{{ $row->meta_description }}]]></description>
	</item>
	@endforeach
</channel>
</rss>
