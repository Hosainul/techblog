@extends('layouts.frontend.app')

@section('title')
    {{$post->title}}
@endsection

@push('css')
    <link href="{{ asset('assets/frontend/css/single-post/styles.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/frontend/css/single-post/responsive.css') }}" rel="stylesheet">
    <style>
        .header-bg{
            height: 400px;
            width: 100%;
            background-image: url({{ Storage::disk('public')->url('post/'.$post->image) }});
            background-size: cover;
        }

        .favorite_posts{
            color: green;
        }
    </style>
@endpush

@section('content')

<div class="header-bg">
</div><!-- slider -->

<section class="post-area section">
    <div class="container">

        <div class="row">

            <div class="col-lg-8 col-md-12 no-right-padding">

                <div class="main-post">

                    <div class="blog-post-inner">

                        <div class="post-info">

                            <div class="left-area">
                                <a class="avatar" href="#"><img src="{{ Storage::disk('public')->url('public/'.$post->user->image) }}" alt="Profile Image"></a>
                            </div>

                            <div class="middle-area">
                                <a class="name" href="#"><b>{{ $post->user->name }}</b></a>
                                <h6 class="date">on {{$post->created_at->diffForHumans() }}</h6>
                            </div>

                        </div><!-- post-info -->

                        <h3 class="title"><a href="#"><b>{{ $post->title }}</b></a></h3>

                        <div class="para">
                            {!! html_entity_decode($post->body) !!}
                        </div>

                        <ul class="tags">
                            @foreach ($post->tags as $tag)
                            <li><a href="{{route('tag.posts',$tag->slug)}}">{{ $tag->name}}</a></li>
                            @endforeach
                        </ul>
                    </div><!-- blog-post-inner -->

                    <div class="post-icons-area">
                        <ul class="post-icons">
                            <li>
                                @guest

                                <a href="javascript:void(0);" onclick="toastr.info('To add favorite list you need to login first','Info',{
                                    closeButton: true,
                                    progressBar: true,
                                })">
                                <i class="ion-heart"></i>{{ $post->favorite_to_users->count() }}</a>

                                @else

                                <a href="javascript:void(0);" onclick="document.getElementById('favorite-form-{{ $post->id }}').submit();"
                                    class="{{ !Auth::user()->favorite_posts->where('pivot.post_id',$post->id)->count()
                                == 0 ? 'favorite_posts' : ''}}">
                                <i class="ion-heart"></i>{{ $post->favorite_to_users->count() }}</a>

                                <form id="favorite-form-{{ $post->id }}" method="POST" action="{{ route('post.favorite',$post->id) }}"
                                    style="display: none;">
                                @csrf
                                </form>
                                
                                @endguest
                                
                            </li>
                            <li><a href="#"><i class="ion-chatbubble"></i>{{$post->comments->count()}}</a></li>
                            <li><a href="#"><i class="ion-eye"></i>{{$post->view_count}}</a></li>
                        </ul>

                        <ul class="icons">
                            <li>SHARE : </li>
                            <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                            <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                            <li><a href="#"><i class="ion-social-pinterest"></i></a></li>
                        </ul>
                    </div>


                </div><!-- main-post -->
            </div><!-- col-lg-8 col-md-12 -->

            <div class="col-lg-4 col-md-12 no-left-padding">

                <div class="single-post info-area">

                    <div class="sidebar-area about-area">
                        <h4 class="title"><b>ABOUT AUTHOR</b></h4>
                        <p>{{$post->user->about}}</p>
                    </div>


                    <div class="tag-area">

                        <h4 class="title"><b>CATEGORIES</b></h4>
                        <ul>
                            @foreach ($post->categories as $category)
                            <li><a href="{{route('category.posts',$category->slug)}}">{{ $category->name}}</a></li>
                            @endforeach
                        </ul>

                    </div><!-- subscribe-area -->

                </div><!-- info-area -->

            </div><!-- col-lg-4 col-md-12 -->

        </div><!-- row -->

    </div><!-- container -->
</section><!-- post-area -->


<section class="recomended-area section">
    <div class="container">
        <div class="row">

    @foreach ($randomPosts as $ramdomPost)
    <div class="col-lg-4 col-md-6">
        <div class="card h-100">
            <div class="single-post post-style-1">

                <div class="blog-image"><img src="{{ Storage::disk('public')->url('post/'.$ramdomPost->image)}}" alt="{{$ramdomPost->title}}"></div>

                <a class="avatar" href="#"><img src="{{ Storage::disk('public')->url('public/'.$ramdomPost->user->image) }}" alt="Profile Image"></a>

                <div class="blog-info">

                    <h4 class="title"><a href="{{ route('post.details',$ramdomPost->slug) }}"><b>{{$ramdomPost->title}}</b></a></h4>

                    <ul class="post-footer">

                        <li>
                            @guest

                            <a href="javascript:void(0);" onclick="toastr.info('To add favorite list you need to login first','Info',{
                                closeButton: true,
                                progressBar: true,
                            })">
                            <i class="ion-heart"></i>{{ $ramdomPost->favorite_to_users->count() }}</a>

                            @else

                            <a href="javascript:void(0);" onclick="document.getElementById('favorite-form-{{ $ramdomPost->id }}').submit();"
                                class="{{ !Auth::user()->favorite_posts->where('pivot.post_id',$post->id)->count()
                            == 0 ? 'favorite_posts' : ''}}">
                            <i class="ion-heart"></i>{{ $ramdomPost->favorite_to_users->count() }}</a>

                            <form id="favorite-form-{{ $ramdomPost->id }}" method="POST" action="{{ route('post.favorite',$ramdomPost->id) }}"
                                style="display: none;">
                            @csrf
                            </form>
                            
                            @endguest
                            
                        </li>
                        <li><a href="#"><i class="ion-chatbubble"></i>{{$ramdomPost->comments->count()}}</a></li>
                        <li><a href="#"><i class="ion-eye"></i>{{$ramdomPost->view_count}}</a></li>
                    </ul>

                </div><!-- blog-info -->
            </div><!-- single-post -->
        </div><!-- card -->
    </div><!-- col-lg-4 col-md-6 -->
    @endforeach

        </div><!-- row -->

    </div><!-- container -->
</section>

<section class="comment-section">
    <div class="container">
        <h4><b>POST COMMENT</b></h4>
        <div class="row">

            <div class="col-lg-8 col-md-12">
                <div class="comment-form">
                    @guest
                        <p>For post a new comment you need to login first.</p>
                        <a href="{{route('login')}}">Login</a>
                    @else
                    <form action="{{route('comment.store',$post->id)}}" method="post">
                        @csrf
                        <div class="row">

                            <div class="col-sm-12">
                                <textarea name="comment" rows="2" class="text-area-messge form-control"
                                    placeholder="Enter your comment" aria-required="true" aria-invalid="false"></textarea >
                            </div><!-- col-sm-12 -->
                            <div class="col-sm-12">
                                <button class="submit-btn" type="submit" id="form-submit"><b>POST COMMENT</b></button>
                            </div><!-- col-sm-12 -->

                        </div><!-- row -->
                    </form>
                    @endguest
            </div><!-- comment-form -->

        <h4><b>COMMENTS({{$post->comments()->count()}})</b></h4>
           @if($post->comments->count() > 0)
            @foreach ($post->comments as $comment)
                <div class="commnets-area ">

                    <div class="comment">

                        <div class="post-info">

                            <div class="left-area">
                                <a class="avatar" href="#"><img src="{{ Storage::disk('public')->url('public/'.$comment->user->image) }}" alt="Profile Image"></a>
                            </div>

                            <div class="middle-area">
                                <a class="name" href="#"><b>{{$comment->user->name}}</b></a>
                                <h6 class="date">on {{$comment->created_at->diffForHumans()}}</h6>
                            </div>

                        </div><!-- post-info -->

                        <p>{{$comment->comment}}</p>

                    </div>

                </div><!-- commnets-area -->

            @endforeach
            @else 
            <div class="commnets-area ">

                <div class="comment">
                    <p>No comment yet, be the first.</p>
                <div>
            <div>
                
            @endif

            </div><!-- col-lg-8 col-md-12 -->

        </div><!-- row -->

    </div><!-- container -->
</section>
@endsection

@push('js')
    
@endpush