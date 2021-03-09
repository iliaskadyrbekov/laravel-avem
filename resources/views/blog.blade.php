@extends('base',  ['right_menu' => $right_menu])

@section('title', 'Blog')

@section('scripts')
    <script src="{{ asset('js/city.js')}}" type="text/javascript"></script>
    <script src="{{ asset('js/blog.js')}}" type="text/javascript"></script>
    <script src="{{ asset('js/copy-button.js')}}" type="text/javascript"></script>
@endsection

@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/blog.css') }}">
@endsection
@section('content')
    <div id="window__posts">
        <div class="window__header">
            <button onclick="goBack()" class="window__back" >
                <img class="window__back-image" src="{{ asset('images/posts/icon-back.svg') }}" alt="icon of close">
            </button>
            <div class="window__title">
                Publication
            </div>
        </div>
        <div class="post__top">

            <div class="post__info">
                <a class="post__person-link" href="/profile/{{ $blog->user->id }}">
                    @if(!is_null($blog->user->profile_image))
                        <img class="post__person-image" src="data:image/png;base64,{{$blog->user->profile_image}}" alt="">
                    @else
                        <img class="post__person-image" src="{{ asset('images/people/default-profile.jpg') }}" alt="icon of person">
                    @endif
                </a>
                <div class="post__data">
                    <a class="post__nickname" href="/profile/{{ $blog->user->id }}">
                      {{$blog->user->first_name." ".$blog->user->last_name}}
                    </a>
                    <div class="post__data-additional">
                        <span class="post__date">{{$blog->created_at->format('F j, Y')}}</span>

                        @if(!empty($blog->place))
                            <a class="post__location-link" href="/place/{{$blog->place->id}}">
                                @elseif(!empty($blog->city))
                                    <a class="post__location-link" href="/city/{{$blog->city->id}}">
                                        @else
                                            <a class="post__location-link" href="#">
                                                @endif
                                                <img class="post__location-image"
                                                     src="{{ asset('images/posts/icon-location.svg') }}"
                                                     alt="icon of location">
                                                @if(!empty($blog->place))
                                                    <div
                                                        class="post__location-name">{{ $blog->place->city->country->country_name.", ".$blog->place->city->city_name.", ".$blog->place->place_name}}</div>
                                                @elseif(!empty($blog->city))
                                                    <div
                                                        class="post__location-name">{{ $blog->city->country->country_name.", ".$blog->city->city_name}}</div>
                                                @else
                                                    <p>None</p>
                                                @endif
                                            </a>
                    </div>
                </div>
            </div>
            <div class="post__bookmark">
                @auth
                    <a class="post__bookmark-link" id="bookmark_{{ $blog->id }}" href="#">
                        @if(auth()->user()->bookmarks->contains($blog))
                            <img class="post__bookmark-image post__bookmark-image--active" src="{{ asset('images/posts/icon-bookmark-active.svg') }}" alt="icon of bookmark">
                        @else
                            <img class="post__bookmark-image" src="{{ asset('images/posts/icon-bookmark-inactive.svg') }}" alt="icon of bookmark">
                        @endif
                    </a>
                @endauth
                @guest
                    <div class="post__bookmark-link_disabled" id="bookmark_{{ $blog->id }}">
                        <img class="post__bookmark-image" src="{{ asset('images/posts/icon-bookmark-inactive.svg') }}" alt="icon of bookmark">
                    </div>
                @endguest
            </div>
        </div>

        <div class="window__images">
            <button class="carusel__left-button" id="scrollLeft"></button>
            <div class="window__carusel-wrapper" id="carusel">
                @foreach($blog->images as $image)
                    <img class="post__image window__carusel-image" id="caruselUnit" src="data:image/jpg;base64,{{$image->image}}"
                         alt="image of post" />
                @endforeach
            </div>
            <button class="carusel__right-button" id="scrollRight"></button>
        </div>


        <div class="post__bottom">
            <div class="post__hashtags">
                @foreach($blog->tags as $tag)
                    <div class="post__hashtags-item">
                        {{'#'.$tag->tag_name}}
                    </div>
                @endforeach
            </div>

            <div class="post__description">
                <p>
                    {{ $blog->blog_text }}
                </p>

            </div>

            <div class="post__feedback window__feedback">
                <div class="post__like">
                    @auth
                        <a class="post__like-link" id="like_{{ $blog->id }}" href="#">
                            @if(auth()->user()->avems->contains($blog))
                                <img class="post__like-image post__like-image--active" src="{{ asset('images/posts/icon-like-active.svg') }}" alt="icon of like">
                            @else
                                <img class="post__like-image" src="{{ asset('images/posts/icon-like-inactive.svg') }}" alt="icon of like">
                            @endif
                            <div class="post__like-text" id="likeAmount">{{$blog->avems->count()}} avem(s)</div>
                        </a>
                    @endauth
                    @guest
                        <div class="post__like-link_disabled" id="like_{{ $blog->id }}">
                            <img class="post__like-image" src="{{ asset('images/posts/icon-like-inactive.svg') }}" alt="icon of like">
                            <div class="post__like-text" id="likeAmount">{{$blog->avems->count()}} avem(s)</div>
                        </div>
                    @endguest
                </div>

                <div class="window__post-share">
                    <a class="post__share-link" onclick='copyToClipboard(window.location.hostname + "/blog/{{ $blog->id }}")' href="#">
                        <img class="post__share-image" src="{{ asset('images/posts/icon-share.svg') }}" alt="icon of share">
                        <div class="post__share-text" id="share--mod">Share</div>
                    </a>
                </div>
            </div>
        </div>

        @if(count($blog->comments) !== 0 || !is_null(auth()->user()))
            <hr class="window__line">
            <div class="window__comments__title-main">
                <div class="comments__title">
                    {{count($blog->comments)}} comment(s)
                </div>
                @error('comment_text')<label class="alert-danger photo__alert">{{ $message }}</label>@enderror
            </div>
        @endif
        @if(!is_null(auth()->user()))
        <form method="post" action="">
            @csrf
            <div class="window__comments">
                <div class="comments__creation">
                    <a class="comments__image-link" href="/profile/{{ auth()->user()->id }}">
                        @if(!is_null(auth()->user()) && !is_null(auth()->user()->profile_image))
                            <img class="comments__image"
                                 src="data:image/jpg;base64,{{auth()->user()->profile_image}}"  alt="icon of person">
                        @else
                            <img class="comments__image"
                                 src="{{ asset('images/people/default-profile.jpg') }}"  alt="icon of person">
                        @endif
                    </a>

                    <textarea class="comments__input" name="comment_text" oninput="auto_grow(this)" type="text"  placeholder="Write a comment"></textarea>
                </div>
            </div>

            <div class="window__btn-comment-wrapper">
                <button class="window__btn-comment"  type="submit">Comment</button>
            </div>
        </form>
        @endif
        <div class="window__chatting">
            @foreach($content['comments'] as $comment)
                <div class="window__message">
                    <div class="window__message-top">
                        <div class="window__message-top-profile">
                            <a class="comments__image-link" href="/profile/{{ $comment->user->id }}">
                                @if(!is_null($comment->user->profile_image))
                                    <img class="comments__image"
                                         src="data:image/jpg;base64,{{$comment->user->profile_image}}"  alt="icon of person">
                                @else
                                    <img class="comments__image"
                                         src="{{ asset('images/people/default-profile.jpg') }}"  alt="icon of person">
                                @endif
                            </a>
                            <div class="window__message-nickname">
                                <a href="/profile/{{ $comment->user->id }}">
                                    {{ $comment->user->first_name." ".$comment->user->last_name }}
                                </a>
                            </div>
                        </div>
                        <div class="window__message-top-date">
                           
                        </div>
                    </div>
                    <div class="window__message-text">
                        <p class="window__message-text-content">
                           {{$comment->comment_text}}
                        </p>
                    </div>

                </div>
            @endforeach
                @if($content['hasMore'])
                    <a href="/blog/{{ $blog->id.'/'.$content['pages'] }}">
                        <button class="posts__btn">SHOW MORE</button>
                    </a>
                @endif
        </div>
    </div>

@endsection

