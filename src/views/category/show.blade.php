@extends('pub_theme::layouts.blog')
@section('blog_content')
 <!-- BLOG POST!! -->
@foreach($rows as $row)
    <article class="post" itemscope itemtype="http://schema.org/Blog">
        <header class="post-header">
            <!-- HOVER IMAGE -->
            <a class="hover-img" href="{{ $row->url }}">
            	{{-- Theme::showImg('theme/pub/img/' . $row->image, ['alt'=>"", 'title'=>""]) --}}
                {!! $row->image() !!}
            </a>
        </header>
        <div class="post-inner">
            <h4 class="post-title"><a href="{{ $row->url }}">{{$row->title}}</a></h4>
            <ul class="post-meta">
                <li><i class="fa fa-calendar"></i><a href="#">{{$row->datePublished}}</a>
                </li>
                <li><i class="fa fa-user"></i><a href="#">{{$row->author}}</a>
                </li>
                <li><i class="fa fa-tags"></i><a href="#">{{$row->tag}}</a>
                </li>
                <li><i class="fa fa-comments"></i><a href="#">{{$row->commentCount}}</a>
                </li>
            </ul>
            <p class="post-desciption">{{$row->abstract}}</p><a class="btn btn-small btn-primary" href="{{ asset('post/' . $row->id) }}">Read More</a>
        </div>
    </article>
@endforeach
{{-- $rows->links() --}}
<div class="gap"></div>
@endsection

@section('blog_sidebar')
{{--  
<aside class="sidebar-right hidden-phone">
    <div class="sidebar-box">
        <h5>Blog Categories</h5>
        <ul class="icon-list blog-category-list">
            @foreach($categories as $category)
                <li><a href="{{ asset('blogs/' . $category->category . '/page/1') }}"><i class="fa fa-angle-right"></i>{{$category->category}}</a></li>
            @endforeach
        </ul>
    </div>

    <div class="sidebar-box">
        <h5>Recent Posts</h5>
        <ul class="thumb-list">
            @foreach($latest_posts as $post)
                <li>
                    <div class="thumb-list-item-caption">
                        <p class="thumb-list-item-meta">{{$post->datePublished}}</p>
                        <h5 class="thumb-list-item-title"><a href="{{ asset('post/' . $post->id) }}">{{$post->title}}</a></h5>
                        <p class="thumb-list-item-desciption">{{$post->text}}</p>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="sidebar-box">
        <h5>Popular Tags</h5>
        <ul class="tags-list">
            @foreach($tags as $tag)
                <li><a href="#">{{$tag->name}}</a></li>
            @endforeach
        </ul>
    </div>
</aside>
--}}
@endsection                    