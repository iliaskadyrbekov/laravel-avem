<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Travelling blogs">
    <meta name="keywords" content="@yield('keywords', 'Avem, travelling blog, where to travel')">
    <meta property="og:url" content="{{url()->current()}}"/>
    <meta property="og:site_name" content="Avem">
    @section('open-graph')
        <meta property="og:title" content="Travelling Blogs | Reviews | Recommendations"/>
        <meta property="og:type" content="website"/>
        <meta property="og:image" content="{{ asset('images/avem_og.png') }}"/>
        <meta property="og:description" content="Website for those, who want to share or find travelling impressions"/>
    @show
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Avem')</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript">
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    </script>
    <script src="{{ asset('js/global-search.js')}}" type="text/javascript"></script>
    <script src="{{ asset('js/general.js')}}" type="text/javascript"></script>
    @yield('scripts')
<!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700&family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;1,400&display=swap"
        rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css"/>
    <link rel="stylesheet" href="{{ asset('css/general.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/left-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/right-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/publications.css') }}">
    <link rel="stylesheet" href="{{ asset('css/search.css') }}">

    @yield('stylesheets')
</head>
<body>
<header class="header">
    <div class="header-wrapper">
        <a href="/home">
            <figure class="logo">
                <img class="logo__img" src="{{ asset('images/FilledOutline.svg') }}" alt="avem logo">
                <figcaption class="logo__text">Avem</figcaption>
            </figure>
        </a>
        <div class="search-box">
            <div class="autocomplete">
                <input class="search-box__field" type="text" autocomplete="off" id="search" name="search"
                       placeholder="Search"><br>
                <a class="magnifier" href="#"></a>
                <div class="lds-dual-ring" id="spinner"></div>
                <div id="searchResults" class="result">
                    {{--results adding here--}}
                </div>
            </div>
        </div>
        <div class="buttons">
            @auth
                <a href="/add-blog" class="buttons__new-post">
                    <button>New post</button>
                </a>
                <form action="/sign-out" method="post">{{ csrf_field() }}<input type="submit" value="Sign out"
                                                                                class="buttons__sign-out"></form>
            @endauth
            @guest
                <a href="/sign-up" class="buttons__new-post">
                    <button>Sign up</button>
                </a>
                <a href="/sign-in" class="buttons__sign-out">Sign in</a>
            @endguest
        </div>
        <nav role="navigation">
            <input class="menu-btn" type="checkbox" id="menu-btn"/>
            <label class="menu-icon" for="menu-btn"><span class="navicon"></span><span class="navicon"></span><span
                    class="navicon"></span></label>
            @auth
                <div class="header-menu">
                    <a class="header-menu__button" href="/home">
                        <div class="header-icon"><img
                                src="{{ asset(request()->is('home*') ? 'images/icon-home-active.svg' : 'images/icon-home.svg' ) }}"
                                alt=""/></div>
                        <div class="header-title"><h2>Home</h2></div>
                    </a>
                    <a class="header-menu__button" href="/profile/{{ auth()->user()->id }}">
                        <div class="header-icon"><img
                                src="{{ asset(request()->is('profile*') ? 'images/icon-profile-active.svg' : 'images/icon-profile.svg') }}"
                                alt=""/></div>
                        <div class="header-title"><h2>Profile</h2></div>
                    </a>
                    <a class="header-menu__button" href="/bookmarks">
                        <div class="header-icon"><img
                                src="{{ asset(request()->is('bookmarks*') ? 'images/icon-bookmarks-active.svg' : 'images/icon-bookmarks-inactive.svg') }}"
                                alt=""/></div>
                        <div class="header-title"><h2>Bookmarks</h2></div>
                    </a>
                    <a class="header-menu__button" href="#">
                        <div class="header-icon"><img
                                src="{{ asset(request()->is('notifications*') ? 'images/icon-notifications-active.svg' : 'images/icon-notifications.svg') }}"
                                alt=""/></div>
                        <div class="header-title"><h2>Notifications</h2></div>
                    </a>
                    <a class="header-menu__button" href="#">
                        <div class="header-icon"><img
                                src="{{ asset(request()->is('settings*') ? 'images/icon-settings-active.svg' : 'images/icon-settings.svg') }}"
                                alt=""/></div>
                        <div class="header-title"><h2>Settings</h2></div>
                    </a>
                    <a class="header-menu__button header-menu__button_activity" href="/add-blog">
                        <div class="header-icon"><img src="{{ asset('images/icon-newpost.svg') }}" alt=""/></div>
                        <div class="header-title"><h2>New post</h2></div>
                    </a>
                    <a class="header-menu__button header-menu__button_subs" href="/subscriptions">
                        <div class="header-icon"><img
                                src="{{ asset(request()->is('subscriptions*') ? 'images/icon-subscriptions-active.svg' : 'images/icon-subscriptions.svg') }}"
                                alt=""/></div>
                        <div class="header-title"><h2>Subscriptions</h2></div>
                    </a>
                    <form action="/sign-out" method="post" class="header-menu__button header-menu__sign-in">
                        {{ csrf_field() }}
                        <input type="submit" value="Sign out">
                    </form>
                </div>
            @endauth
            @guest
                <div class="header-menu header-menu_unsigned">
                    <a class="header-menu__button" href="/home">
                        <div class="header-icon"><img
                                src="{{ asset(request()->is('home*') ? 'images/icon-home-active.svg' : 'images/icon-home.svg' ) }}"
                                alt="home icon"/></div>
                        <div class="header-title"><h2>Home</h2></div>
                    </a>
                    <a class="header-menu__button" href="/sign-in">
                        <div class="header-icon"><img src="{{ asset('images/icon-profile.svg') }}" alt="profile icon"/>
                        </div>
                        <div class="header-title"><h2>Profile</h2></div>
                    </a>
                    <a class="header-menu__button header-menu__button_activity" href="/sign-up">
                        <div class="header-icon"><img src="{{ asset('images/icon-signup.svg') }}" alt="sign up icon"/>
                        </div>
                        <div class="header-title"><h2>Sign up</h2></div>
                    </a>
                    <a class="header-menu__button header-menu__sign-in" href="/sign-in">
                        <div class="header-title"><h2>Sign in</h2></div>
                    </a>
                </div>
            @endguest
        </nav>
    </div>
</header>
<main>
    <div class="main-wrapper">
        @section('left-menu') {{--CAN BE REMOVED, OR CHANGED FOR SIGNED OUT PERSON--}}
        @auth
            <div class="left-menu">
                <a class="left-menu__button" href="/home">
                    <div class="button__icon"><img
                            src="{{ asset(request()->is('home*') ? 'images/icon-home-active.svg' : 'images/icon-home.svg' ) }}"
                            alt=""/></div>
                    <div class="button__title"><h2>Home</h2></div>
                </a>
                <a class="left-menu__button" href="/profile/{{ auth()->user()->id }}">
                    <div class="button__icon"><img
                            src="{{ asset(request()->is('profile*') ? 'images/icon-profile-active.svg' : 'images/icon-profile.svg') }}"
                            alt=""/></div>
                    <div class="button__title"><h2>Profile</h2></div>
                </a>
                <a class="left-menu__button" href="/bookmarks">
                    <div class="button__icon"><img
                            src="{{ asset(request()->is('bookmarks*') ? 'images/icon-bookmarks-active.svg' : 'images/icon-bookmarks-inactive.svg') }}"
                            alt=""/></div>
                    <div class="button__title"><h2>Bookmarks</h2></div>
                </a>
                <a class="left-menu__button" href="#">
                    <div class="button__icon"><img
                            src="{{ asset(request()->is('notifications*') ? 'images/icon-notifications-active.svg' : 'images/icon-notifications.svg') }}"
                            alt="notifications icon"/></div>
                    <div class="button__title"><h2>Notifications</h2></div>
                </a>
                <a class="left-menu__button" href="#">
                    <div class="button__icon"><img
                            src="{{ asset(request()->is('settings*') ? 'images/icon-settings-active.svg' : 'images/icon-settings.svg') }}"
                            alt="settings icon"/></div>
                    <div class="button__title"><h2>Settings</h2></div>
                </a>
                <a class="left-menu__button left-menu__button_activity" href="/add-blog">
                    <div class="button__icon"><img src="{{ asset('images/icon-newpost.svg') }}" alt="add blog icon"/>
                    </div>
                    <div class="button__title"><h2>New post</h2></div>
                </a>
                <a class="left-menu__button left-menu__button_subs" href="/subscriptions">
                    <div class="button__icon"><img
                            src="{{ asset(request()->is('subscriptions*') ? 'images/icon-subscriptions-active.svg' : 'images/icon-subscriptions.svg') }}"
                            alt="subscriptions icon"/></div>
                    <div class="button__title"><h2>Subscriptions</h2></div>
                </a>
            </div>
        @endauth
        @guest
            <div class="left-menu_unsigned ">
                <a class="left-menu__button" href="/home">
                    <div class="button__icon"><img
                            src="{{ asset(request()->is('home*') ? 'images/icon-home-active.svg' : 'images/icon-home.svg') }}"
                            alt="home icon"/></div>
                    <div class="button__title"><h2>Home</h2></div>
                </a>
                <a class="left-menu__button" href="/sign-in">
                    <div class="button__icon"><img src="{{ asset('images/icon-profile.svg') }}" alt="profile icon"/>
                    </div>
                    <div class="button__title"><h2>Profile</h2></div>
                </a>
                <a class="left-menu__button left-menu__button_activity" href="/sign-up">
                    <div class="button__icon"><img src="{{ asset('images/icon-signup.svg') }}" alt="sign up icon"/>
                    </div>
                    <div class="button__title"><h2>Sign up</h2></div>
                </a>
            </div>
        @endguest
        <div class="left-menu-holder"></div>
        @show
        <div class="content">
            @section('content') {{--MUST BE CHANGED--}}
            ERROR
            @show
        </div>
        <div class="right-menu">
            <div class="right-menu__title">
                @if(auth()->check() and $right_menu['hasFollowings'])
                    <h2>Your subscriptions</h2>
                @else
                    <h2>Most popular</h2>
                @endif
            </div>
            <div class="right-menu__people">
                @foreach($right_menu['people'] as $person)
                    <a class="people__person" href="/profile/{{ $person->id }}">
                        <div class="person__image">
                            @if(!is_null($person->profile_image))
                                <img src="data:image/jpg;base64,{{$person->profile_image}}" alt="profile-image">
                            @else
                                <img src="{{ asset('images/people/default-profile.jpg') }}" alt="profile-image">
                            @endif
                        </div>
                        <div class="person__info">
                            <div class="info__name">
                                <h4>
                                    @if(strlen(($person->first_name.' '.$person->last_name)) > 13)
                                        {{ substr(($person->first_name.' '.$person->last_name),0,13)."..." }}
                                    @else
                                        {{ $person->first_name.' '.$person->last_name }}
                                    @endif
                                </h4>
                            </div>
                            <div class="info__posts"><h4>{{ $person->blogs()->count() }} posts</h4></div>
                        </div>
                    </a>
                    @if(!$loop->last)
                        <hr>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</main>
<div class="footer-wrapper">
    <div class="no-left-menu"></div>
    <footer class="footer">
        <h5>© 2020 Avem</h5>
    </footer>
    <div class="no-right-menu"></div>
</div>
</body>
</html>
