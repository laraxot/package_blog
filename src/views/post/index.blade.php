 <!-- BLOG POST -->
@foreach($blogs as $blog)
    <article class="post" itemscope itemtype="http://schema.org/Blog">
        <header class="post-header">
            <!-- HOVER IMAGE -->
            <a class="hover-img" href="post-sidebar-right.html">
            	{!! Theme::showImg('theme/pub/img/' . $blog->image, ['alt'=>"", 'title'=>""]) !!}
            </a>
        </header>
        <div class="post-inner">
            <h4 class="post-title"><a href="post-sidebar-right.html">{{$blog->title}}</a></h4>
            <ul class="post-meta">
                <li><i class="fa fa-calendar"></i><a href="#">{{$blog->datePublished}}</a>
                </li>
                <li><i class="fa fa-user"></i><a href="#">{{$blog->author}}</a>
                </li>
                <li><i class="fa fa-tags"></i><a href="#">{{$blog->tag}}</a>
                </li>
                <li><i class="fa fa-comments"></i><a href="#">{{$blog->commentCount}}</a>
                </li>
            </ul>
            <p class="post-desciption">{{$blog->abstract}}</p><a class="btn btn-small btn-primary" href="{{ asset('post/' . $blog->id) }}">Read More</a>
        </div>
    </article>
@endforeach

<ul class="pagination">
    <li class="prev disabled">
        <a href="#"></a>
    </li>
    <li class="active"><a href="#">1</a>
    </li>
    <li><a href="#">2</a>
    </li>
    <li><a href="#">3</a>
    </li>
    <li><a href="#">4</a>
    </li>
    <li><a href="#">5</a>
    </li>
    <li class="next">
        <a href="#"></a>
    </li>
</ul>
<div class="gap"></div>