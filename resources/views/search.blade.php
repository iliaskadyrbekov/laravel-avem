@extends('base')

@section('title', 'Search Results')

@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/blog.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('js/copy-button.js')}}" type="text/javascript"></script>
@endsection

@section('content')
    <div class="posts">
        @if($contents['blogs']->count() == 0)
            <h5>No search results</h5>
        @endif
        @foreach($contents['blogs'] as $blog)
            <div class="post">
                <div class="post__top">
                    <div class="post__info">
                        <a class="post__person-link" href="/profile/{{ $blog->user->id }}">
                            @if(!is_null($blog->user->profile_image))
                                <img class="post__person-image"
                                     src="data:image/jpg;base64,{{$blog->user->profile_image}}" alt="">
                            @else
                                <img class="post__person-image" src="{{ asset('images/people/default-profile.jpg') }}"
                                     alt="">
                            @endif
                        </a>
                        <div class="post__data">
                            <a class="post__nickname" href="/profile/{{ $blog->user->id }}">
                                {{ $blog->user->first_name." ".$blog->user->last_name }}
                            </a>
                            <div class="post__data-additional">
                                <span class="post__date">{{ $blog->created_at->format('F j, Y')}}</span>

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
                            <a class="post__bookmark-link" id="bookmark_{{ $blog->id }}"
                               href="/profile/{{ $blog->user->id }}">
                                @if(auth()->user()->bookmarks->contains($blog))
                                    <img class="post__bookmark-image post__bookmark-image--active"
                                         src="{{ asset('images/posts/icon-bookmark-active.svg') }}"
                                         alt="icon of bookmark">
                                @else
                                    <img class="post__bookmark-image"
                                         src="{{ asset('images/posts/icon-bookmark-inactive.svg') }}"
                                         alt="icon of bookmark">
                                @endif
                            </a>
                        @endauth
                        @guest
                            <div class="post__bookmark-link_disabled" id="bookmark_{{ $blog->id }}">
                                <img class="post__bookmark-image"
                                     src="{{ asset('images/posts/icon-bookmark-inactive.svg') }}"
                                     alt="icon of bookmark">
                            </div>
                        @endguest
                    </div>
                </div>

                <a class="window__images" href="{{ route('blog', $blog->id) }}">
                    <div class="window__carusel-wrapper carusel">
                        <img class="post__image window__carusel-image caruselUnit"
                             src="data:image/jpg;base64,{{$blog->images[0]->image}}"
                             alt="image of post"/>
                    </div>
                </a>

                <div class="post__bottom">
                    <div class="post__hashtags">
                        @foreach($blog->tags as $tag)
                            <div class="post__hashtags-item">
                                {{'#'.$tag->tag_name}}
                            </div>
                        @endforeach
                    </div>

                    <a class="post__description" href="{{ route('blog', $blog->id) }}">
                        <p>
                            @if(strlen(($blog->blog_text)) > 200)
                                {{ substr(($blog->blog_text),0,200)."..."}}<span class="post__detail">Read more</span>
                            @else
                                {{ $blog->blog_text }}
                            @endif
                        </p>
                    </a>

                    <div class="post__feedback">
                        <div class="post__like">
                            @auth
                                <a class="post__like-link" id="like_{{ $blog->id }}" href="#">
                                    @if(auth()->user()->avems->contains($blog))
                                        <img class="post__like-image post__like-image--active"
                                             src="{{ asset('images/posts/icon-like-active.svg') }}" alt="icon of like">
                                    @else
                                        <img class="post__like-image"
                                             src="{{ asset('images/posts/icon-like-inactive.svg') }}"
                                             alt="icon of like">
                                    @endif
                                    <div class="post__like-text" id="likeAmount">{{$blog->avems->count()}} avem(s)</div>
                                </a>
                            @endauth
                            @guest
                                <div class="post__like-link_disabled" id="like_{{ $blog->id }}">
                                    <img class="post__like-image"
                                         src="{{ asset('images/posts/icon-like-inactive.svg') }}" alt="icon of like">
                                    <div class="post__like-text" id="likeAmount">{{$blog->avems->count()}} avem(s)</div>
                                </div>
                            @endguest
                        </div>
                        <div class="post__comment">
                            <a class="post__comment-link" href="/blog/{{ $blog->id }}">
                                <div class="post__comment-text">{{$blog->comments->count()}} comment(s)</div>
                            </a>
                        </div>
                        <div class="post__share">
                            <a class="post__share-link" onclick='copyToClipboard(window.location.hostname + "/blog/{{ $blog->id }}")' href="#">
                                <img class="post__share-image" src="{{ asset('images/posts/icon-share.svg') }}"
                                     alt="icon of share">
                                <div class="post__share-text" id="share--mod">Share</div>
                            </a>
                        </div>
                    </div>

                    <div class="post__share-none">
                        <a class="post__share-link-none" onclick='copyToClipboard(window.location.hostname + "/blog/{{ $blog->id }}")' href="#">
                            <img class="post__share-image" src="{{ asset('images/posts/icon-share.svg') }}"
                                 alt="icon of share">
                            <div class="post__share-text-none" id="share--mod">Share</div>
                        </a>
                    </div>
                </div>
            </div>
            @if(!$loop->last)
                <hr class="post__line">
            @endif
        @endforeach
        @if($contents['hasMore'])
            <a href="/search{{ '/s='.$search_parameter.'/'.$contents['pages'] }}">
                <button class="posts__btn">SHOW MORE</button>
            </a>
        @endif
    </div>
@endsection
