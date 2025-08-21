@foreach ($data as $blog)
<div class="col-lg-4 col-md-6">
    <div class="single-blog-box">
        <div class="single-blog-thumb">
            <img src="{{asset('blog/'.$blog->image)}}" alt="{{ $blog->title }}"> 						
        </div>
        <div class="blog-content">
            <div class="meta-blog">
                <p><span class="solution">{{ $blog->category->name }}</span>{{ \Carbon\Carbon::parse($blog->created_at)->format('d M, Y') }}</p>
            </div>
            <div class="blog-title">
                <h3><a href="{{ route('blog_details', [$blog->slug]) }}">{{ Str::limit($blog->title, 50, '...') }}</a></h3>
            </div>
            <div class="blog_btn">
                <a href="{{ route('blog_details', [$blog->slug]) }}">Read More <i class="flaticon flaticon-right-arrow"></i></a>
            </div>
        </div>
    </div>
</div>  
@endforeach