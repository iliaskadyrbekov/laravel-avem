@extends('base', ['right_menu' => $right_menu])

@section('title', 'Edit Profile')

@section('scripts')
    <script src="{{ asset('js/city.js')}}" type="text/javascript"></script>
    <script src="{{ asset('js/blog.js')}}" type="text/javascript"></script>
    <script src="{{ asset('js/city-search.js')}}" type="text/javascript"></script>
    <script src="{{ asset('js/profile-edit.js')}}" type="text/javascript"></script>
@endsection

@section('stylesheets')
    <link rel="stylesheet" href="{{asset('css/publications.css')}}">
    <link rel="stylesheet" href="{{asset('css/profile.css')}}">
    <link rel="stylesheet" href="{{asset('css/profile-edit.css')}}">
@endsection

@section('content')
    <div class="profile-info">
        <div class="add-blog__title-info">
            <button onclick="goBack()" class="add-blog__btn-back">
                <img class="add-blog__back-image" src="{{ asset('images/posts/icon-back.svg') }}" alt="icon of close">
            </button>
            <div class="add-blog__title">
                Edit profile
            </div>
        </div>
        <form class="profile-edit" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            @if(!is_null($user->background_image))
                <label for="poster-img" id="bg_img" class="poster-upload"
                       style="background: linear-gradient(0deg, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('data:image/jpg;base64,{{$user->background_image}}') 50% 50% no-repeat;background-size: cover;">
                    @else
                        <label for="poster-img" id="bg_img" class="poster-upload"
                               style="background: linear-gradient(0deg, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('{{asset('images/profile/background/default.jpg')}}') 50% 50% no-repeat;background-size: cover;">
                            @endif
                            <img class="poster__icon" src="{{asset('images/posts/icon-take-photo.svg')}}">
                            @if(!is_null($user->profile_image))
                                <label for="poster-avatar" id="prof_img" class="poster-upload__avatar"
                                       style="background:  linear-gradient(0deg, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('data:image/jpg;base64,{{$user->profile_image}}') 50% 50% no-repeat; background-size: cover;">
                                    @else
                                        <label for="poster-avatar" id="prof_img" class="poster-upload__avatar"
                                               style="background:  linear-gradient(0deg, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('{{asset('images/people/default-profile.jpg')}}') 50% 50% no-repeat; background-size: cover;">
                                            @endif
                                            <img class="poster__icon"
                                                 src="{{asset('images/posts/icon-take-photo.svg')}}">
                                        </label>
                                        <input name="profile_image" class="@error('profile_image') is-invalid @enderror"
                                               type="file" id="poster-avatar" accept="image/png, image/jpeg">
                                </label>
                                <input name="background_image" class="@error('background_image') is-invalid @enderror"
                                       type="file" id="poster-img" accept="image/png, image/jpeg">
                                @error('profile_image')<label class="alert-danger">{{ $message }}</label>@enderror
                                @error('background_image')<label class="alert-danger">{{ $message }}</label>@enderror
                                <label class="profile-edit__label">First Name</label>
                                @error('first_name')<label class="alert-danger">{{ $message }}</label>@enderror
                                <input name="first_name" type="text" class="@error('first_name') is-invalid @enderror"
                                       value="{{$user->first_name}}">

                                <label class="profile-edit__label">Last Name</label>
                                @error('last_name')<label class="alert-danger">{{ $message }}</label>@enderror
                                <input name="last_name" type="text" class="@error('last_name') is-invalid @enderror"
                                       value="{{$user->last_name}}">

                                <label class="profile-edit__label"><span>Profile Status</span><span
                                        id="inputCounter"></span></label>
                                @error('status')<label class="alert-danger">{{ $message }}</label>@enderror
                                <input name="status" type="text" id="status" class="@error('status') is-invalid @enderror" maxlength="100"
                                       value="{{$user->status}}">

                                <label class="profile-edit__label">Description</label>
                                @error('description')<label class="alert-danger">{{ $message }}</label>@enderror
                                <textarea name="description" oninput="auto_grow(this)"
                                          class="input-share @error('status') is-invalid @enderror">{{$user->description}}</textarea>

                                <div class="box__labels">
                                    <label class="profile-edit__label">Location</label>
                                    @error('location')<label class="alert-danger">{{ $message }}</label>@enderror
                                </div>
                                <div class="autocomplete">
                                    <input type="text" autocomplete="off" id="location" name="location"
                                           placeholder="Country, City"
                                           value="{{$user->city->country->country_name.", ".$user->city->city_name}}"
                                           class="@error('location') is-invalid @enderror"><br>
                                    <div class="lds-dual-ring" id="spinner"></div>
                                    <div id="locationResults" class="result">
                                        {{--results adding here--}}
                                    </div>
                                </div>
                                <div class="lds-dual-ring" id="spinner"></div>
                                <div id="locationResults" class="result"></div>
                                <div class="add-blog__header">
                                    <div class="add-blog__btn-post-wrapper">
                                        <button class="add-blog__btn-post" type="submit">Save</button>
                                    </div>
                                </div>
        </form>
    </div>
@endsection
