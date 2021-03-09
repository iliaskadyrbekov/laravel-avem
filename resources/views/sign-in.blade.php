@extends('base', ['right_menu' => $right_menu])

@section('title', 'Sign In')

@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/sign.css') }}">
@endsection

@section('content')
    <div class="content__title">
        <div class="title__top">
            <h3>Welcome back</h3>
        </div>
        <div class="title__bottom">
            <h1>Sign in to Avem</h1>
        </div>
    </div>
    <form class="content__form" action="/sign-in" method="post">
        {{ csrf_field() }}
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
        <input class="form__submit" type="submit" value="Confirm">
    </form>
@endsection
