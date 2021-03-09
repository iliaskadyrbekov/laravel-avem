@extends('base')

@section('title', 'Subscriptions')

@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/subscriptions.css') }}">
@endsection

@section('content')
    <div class="subscriptions">
        <div class="subscriptions__title">
            @if(auth()->check() and $contents['hasFollowings'])
                <h2>Your subscriptions</h2>
            @else
                <h2>Most popular</h2>
            @endif
        </div>
        <div class="subscriptions__people" style="grid-template-rows: repeat({{count($contents['people'])-1}}, 48px 1px) 48px;">
            @foreach($contents['people'] as $person)
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
                            <h4>{{ $person->first_name.' '.$person->last_name }}</h4>
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
    @if($contents['hasMore'])
        <a href="/subscriptions/{{ $contents['pages'] }}">
            <button class="posts__btn">SHOW MORE</button>
        </a>
    @endif
@endsection
