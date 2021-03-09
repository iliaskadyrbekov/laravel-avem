@extends('base',  ['right_menu' => $right_menu])

@section('title', 'Sign Up')

@section('scripts')
    <script src="{{ asset('js/city-search.js')}}" type="text/javascript"></script>
@endsection

@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/sign.css') }}">
@endsection

@section('content')
    <div class="content__title">
        <div class="title__top">
            <h3>Join Avem</h3>
        </div>
        <div class="title__bottom">
            <h1>Create your account</h1>
        </div>
    </div>
    <form class="content__form" action="/sign-up" method="post">
        {{ csrf_field() }}
        <div class="form__box">
            <div class="box__labels">
                <label for="first_name">First name <span style="color: red;">*</span></label>
                @error('first_name')<label class="alert-danger">{{ $message }}</label>@enderror
            </div>
            <input type="text" id="first_name" name="first_name" placeholder="Christopher" value="{{old('first_name')}}" class="@error('first_name') is-invalid @enderror"><br>
        </div>
        <div class="form__box">
            <div class="box__labels">
                <label for="last_name">Last name</label>
                @error('last_name')<label class="alert-danger">{{ $message }}</label>@enderror
            </div>
            <input type="text" id="last_name" name="last_name" placeholder="Columbus" value="{{old('last_name')}}"  class="@error('last_name') is-invalid @enderror"><br>
        </div>
        <div class="form__box">
            <div class="box__labels">
                <label for="email">Email <span style="color: red;">*</span></label>
                @error('email')<label class="alert-danger">{{ $message }}</label>@enderror
            </div>
            <input type="email" id="email" name="email" placeholder="login@gmail.com" value="{{old('email')}}"  class="@error('email') is-invalid @enderror"><br>
        </div>
        <div class="form__box">
            <div class="box__labels">
                <label for="password">Password <span style="color: red;">*</span></label>
                @error('password')<label class="alert-danger">{{ $message }}</label>@enderror
            </div>
            <input type="password" id="password" name="password" placeholder="**********" class="@error('password') is-invalid @enderror"><br>
        </div>
        <div class="form__box">
            <div class="box__labels">
                <label for="birth">Birth</label>
                @error('birth')<label class="alert-danger">{{ $message }}</label>@enderror
            </div>
            <input type="date" id="birth" name="birth" value="{{old('birth')}}"  class="@error('birth') is-invalid @enderror"><br>
        </div>
        <div class="form__box">
            <div class="box__labels">
                <label for="location">Location <span style="color: red;">*</span></label>
                @error('location')<label class="alert-danger">{{ $message }}</label>@enderror
            </div>
            <div class="autocomplete">
                <input type="text" autocomplete="off" id="location" name="location" placeholder="Country, City" value="{{old('location')}}"  class="@error('location') is-invalid @enderror"><br>
                <div class="lds-dual-ring" id="spinner"></div>
                <div id="locationResults" class="result">
                    {{--results adding here--}}
                </div>
            </div>

        </div>

        <input class="form__submit" type="submit" value="Confirm">
    </form>
@endsection

