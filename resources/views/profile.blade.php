@extends('base', ['right_menu' => $right_menu])

@section('title', 'Profile')

@section('scripts')
    <script src="{{ asset('js/city.js')}}" type="text/javascript" xmlns:data="http://www.w3.org/1999/xhtml"></script>
    <script src="{{ asset('js/copy-button.js')}}" type="text/javascript"></script>
@endsection

@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
    <div class="profile-info">
        @if(!is_null($profile_owner->background_image))
            <div class="info__poster"
                 style="background: linear-gradient(180deg, rgba(0, 0, 0, 0) 35.42%, rgba(0, 0, 0, 0.49) 100%), url('data:image/jpg;base64,{{$profile_owner->background_image}}') 100% 100% no-repeat;background-position: center;background-size: cover">
                @else
                    <div class="info__poster"
                         style="background: linear-gradient(180deg, rgba(0, 0, 0, 0) 35.42%, rgba(0, 0, 0, 0.49) 100%), url('{{ asset('images/profile/background/default.jpg') }}') 100% 100% no-repeat;background-position: center;background-size: cover">
                        @endif
                        <div class="poster__wrapper">
                            <div class="poster__avatar-name">
                                @if(!is_null($profile_owner->profile_image))
                                    <img class="poster__avatar"
                                         src="data:image/jpg;base64,{{$profile_owner->profile_image}}"
                                         alt="profile-image">
                                @else
                                    <img class="poster__avatar" src="{{ asset('images/people/default-profile.jpg') }}"
                                         alt="profile-image">
                                @endif
                                <div class="poster__name">
                                    <h1>{{ $profile_owner->first_name.' '.$profile_owner->last_name }}</h1>
                                    <div class="poster__follow">
                                        <div class="follow__followers">
                                            <p>Followers</p>
                                            <p id="followers">{{ $profile_owner->followers()->count() }}</p>
                                        </div>
                                        <div class="follow__following">
                                            <p>Following</p>
                                            <p id="following">{{ $profile_owner->followings()->count() }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mob__follow">
                        <div class="mob__wrapper">
                            <div class="follow__followers">
                                <p>Followers</p>
                                <p id="followers">{{ $profile_owner->followers()->count() }}</p>
                            </div>
                            <div class="follow__following">
                                <p>Following</p>
                                <p id="following">{{ $profile_owner->followings()->count() }}</p>
                            </div>
                        </div>


                        @auth
                            @if(auth()->user()->id != $profile_owner->id)
                                @if(!auth()->user()->followings->contains($profile_owner))
                                    <form action="/profile-follow/{{$profile_owner->id}}" method="post">
                                        @csrf
                                        <button class="follow__mobile"  value="Follow" type="submit">Follow</button>

                                    </form>
                                @else
                                    <form action="/profile-unfollow/{{$profile_owner->id}}" method="post">
                                        @csrf
                                        <button class="unfollow__mobile"  value="Unfollow" type="submit">Unfollow</button>
                                    </form>
                                @endif
                            @endif
                        @endauth

                    </div>
                    @auth
                        @if($profile_owner->id == auth()->user()->id)
                            <div class="mob__edit">
                                <a href="/profile-edit/{{$profile_owner->id}}">Edit
                                    profile</a>
                            </div>
                        @endif
                    @endauth
                    <div class="info__about">
                        <div class="about__text">
                            @if(!is_null($profile_owner->status))
                                <p>{{ $profile_owner->status }}</p>
                                <hr>
                            @endif
                        </div>
                        <div class="about__description">
                            <div class="description__text">
                                <h2>Profile description</h2>
                                @auth
                                    @if($profile_owner->id == auth()->user()->id)
                                        <a href="/profile-edit/{{$profile_owner->id}}"><img id="description__pen"
                                                                                            src="{{ asset('images/icon-edit-pen.svg') }}"></a>
                                    @endif
                                @endauth
                            </div>
                            @auth
                                @if(auth()->user()->id != $profile_owner->id)
                                    @if(!auth()->user()->followings->contains($profile_owner))
                                        <form action="/profile-follow/{{$profile_owner->id}}"
                                              method="post">{{ csrf_field() }}
                                            <input type="submit" value="Follow" class="description__follow"></form>
                                    @else
                                        <form action="/profile-unfollow/{{$profile_owner->id}}"
                                              method="post">{{ csrf_field() }}<input type="submit" value="Unfollow"
                                                                                     class="description__unfollow">
                                        </form>
                                    @endif
                                @endif
                            @endauth
                        </div>
                        <div class="about__story">
                            @if(strlen(($profile_owner->description)) > 200)
                                <p>{{ substr(($profile_owner->description),0,200)."..." }}</p>
                            @else
                                <p>{{ $profile_owner->description ?? ' ' }}<p>
                            @endif
                            <hr>
                            {{--<div id="read-more">
                                <a href="#">Read more</a>
                                <a href="#"><img src="{{ asset('images/icon-arrow-down.svg') }}"></a>
                            </div>--}}
                        </div>
                    </div>
                    @if(count($visited) != 0)
                        <div class="info__carusel">
                            <div class="carusel__title">
                                <h2>Visited places</h2>
                            </div>
                            <button class="carusel__left-button" id="scrollLeft"></button>
                            <button class="carusel__right-button" id="scrollRight"></button>
                            <div class="carusel__holder" id="carusel">
                                @switch(count($visited))
                                    @case(1)
                                    <a href="/place/{{$visited[0]->id}}" class="holder__image" id="caruselUnit" style="flex: 0 0 100%; background-image: linear-gradient(180deg, rgba(255, 255, 255, 0) 0%, rgba(0, 0, 0, 0.3) 100%), url(data:image/jpg;base64,{{$visited[0]->background_image}})">
                                        <h3>{{ $visited[0]->city->city_name ?? $city->city_name }}</h3>
                                        <p>{{ $visited[0]->place_name ?? 'empty'}}</p>
                                    </a>
                                    @break
                                    @case(2)
                                    @foreach($visited as $place)
                                        <a href="/place/{{$place->id}}" class="holder__image" id="caruselUnit" style="flex: 0 0 50%; background-image: linear-gradient(180deg, rgba(255, 255, 255, 0) 0%, rgba(0, 0, 0, 0.3) 100%), url(data:image/jpg;base64,{{$place->background_image}})">
                                            <h3>{{ $place->city->city_name ?? $city->city_name }}</h3>
                                            <p>{{ $place->place_name ?? 'empty'}}</p>
                                        </a>
                                    @endforeach
                                    @break
                                    @default
                                    @foreach($visited as $place)
                                        <a href="/place/{{$place->id}}" class="holder__image" id="caruselUnit" style="background-image: linear-gradient(180deg, rgba(255, 255, 255, 0) 0%, rgba(0, 0, 0, 0.3) 100%), url(data:image/jpg;base64,{{$place->background_image}})">
                                            <h3>{{ $place->city->city_name ?? $city->city_name }}</h3>
                                            <p>{{ $place->place_name ?? 'empty'}}</p>
                                        </a>
                                    @endforeach
                                    @break
                                @endswitch
                            </div>
                        </div>
                    @endif
            </div>
            <div class="posts">
                @if(count($profile_owner->blogs) > 0)
                    <h2 class="posts__title">Publications<span id="publication_counter">({{count($profile_owner->blogs)}})</span>
                    </h2>
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
                                        <img class="post__person-image"
                                             src="{{ asset('images/people/default-profile.jpg') }}" alt="">
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
                                                     src="{{ asset('images/posts/icon-like-active.svg') }}"
                                                     alt="icon of like">
                                            @else
                                                <img class="post__like-image"
                                                     src="{{ asset('images/posts/icon-like-inactive.svg') }}"
                                                     alt="icon of like">
                                            @endif
                                            <div class="post__like-text" id="likeAmount">{{$blog->avems->count()}}
                                                avem(s)
                                            </div>
                                        </a>
                                    @endauth
                                    @guest
                                        <div class="post__like-link_disabled" id="like_{{ $blog->id }}">
                                            <img class="post__like-image"
                                                 src="{{ asset('images/posts/icon-like-inactive.svg') }}"
                                                 alt="icon of like">
                                            <div class="post__like-text" id="likeAmount">{{$blog->avems->count()}}
                                                avem(s)
                                            </div>
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
                    <a href="/profile/{{ $profile_owner->id.'/'.$contents['pages'] }}">
                        <button class="posts__btn">SHOW MORE</button>
                    </a>
                @endif
            </div>
@endsection
