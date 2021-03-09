@extends('base',  ['right_menu' => $right_menu])

@section('title', 'Add blog')

@section('scripts')
    <script src="{{ asset('js/city.js')}}" type="text/javascript"></script>
    <script src="{{ asset('js/blog.js')}}" type="text/javascript"></script>
    <script src="{{ asset('js/place-search.js')}}" type="text/javascript"></script>
@endsection

@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('css/blog.css') }}">
    <link rel="stylesheet" href="{{ asset('css/add-blog.css') }}">

@endsection

@section('content')
    <div class="add-blog">
    <div class="add-blog__title-info">
        <button onclick="goBack()" class="add-blog__btn-back">
            <img class="add-blog__back-image" src="{{ asset('images/posts/icon-back.svg') }}" alt="icon of close">
        </button>
        <div class="add-blog__title">
            Add Blog
        </div>
    </div>
    <form class="add-blog__form" action="" method="post" enctype="multipart/form-data">
        @csrf
        <div class="box__labels photo__box-labels">
            <label class="photo__title" for="photo">Photo <span style="color: red;">*</span></label>
            @error('photo')<label class="alert-danger photo__alert">{{ $message }}</label>@enderror
        </div>
        <div class="add-blog__carusel">
            <div  class="add-blog__download-photo" id="carusel">
                <div class="add-blog__take-photo " id="caruselUnit1" class="@error('photo[1]') is-invalid @enderror">
                    <label for="file-upload1" class="custom-file-upload" >
                        <img class="take-photo__btn-image" src="{{ asset('images/posts/icon-take-photo.svg') }}"
                             alt="icon for add of photo ">
                    </label>
                    <input type="file"  id="file-upload1" name="photo[]" accept="image/png, image/jpeg"/>
                </div>

                <div class="add-blog__take-photo " id="caruselUnit2" class="@error('photo[2]') is-invalid @enderror">
                    <label for="file-upload2" class="custom-file-upload" >
                        <img class="take-photo__btn-image" src="{{ asset('images/posts/icon-take-photo.svg') }}"
                             alt="icon for add of photo ">
                    </label>
                    <input type="file"  id="file-upload2" name="photo[]" accept="image/png, image/jpeg"/>
                </div>

                <div class="add-blog__take-photo" id="caruselUnit" class="@error('photo[3]') is-invalid @enderror">
                    <div id="caruselUnit3">
                    <label for="file-upload3" class="custom-file-upload" >
                        <img class="take-photo__btn-image" src="{{ asset('images/posts/icon-take-photo.svg') }}"
                             alt="icon for add of photo ">

                    </label>
                    <input type="file"  id="file-upload3" name="photo[]" accept="image/png, image/jpeg"/>
                    </div>
                </div>

            </div>
            <button class="add-blog__carusel-right-button" id="scrollRight"></button>
            <button class="add-blog__carusel-left-button" id="scrollLeft"></button>
        </div>

        <div class="add-blog__additional-info">
            <div class="add-blog__additional-info-item">
                <div class="box__labels">
                    <label for="location">Location <span style="color: red;">*</span></label>
                    @error('location')<label class="alert-danger">{{ $message }}</label>@enderror
                </div>
                <div class="autocomplete">
                    <input type="text" autocomplete="off" id="location" name="location" placeholder="Country, City (or Country, City, Place)" value="{{old('location')}}"  class="@error('location') is-invalid @enderror"><br>
                    <div class="lds-dual-ring" id="spinner"></div>
                    <div id="locationResults" class="result">
                        {{--results adding here--}}
                    </div>
                </div>
            </div>

            <div class="add-blog__additional-info-item">
                <div class="box__labels">
                    <label for="blog_text">Your expressions <span style="color: red;">*</span></label> {{--<span style="color: red;">*</span>--}}
                    @error('blog_text')<label class="alert-danger">{{ $message }}</label>@enderror
                </div>
                <textarea id="blog_text" name="blog_text" oninput="auto_grow(this)" class="input-share @error('blog_text') is-invalid @enderror">{{old('blog_text')}}</textarea><br>
            </div>

            <div class="add-blog__additional-info-item add-blog__additional-info-item-tags">
                <div class="box__labels">
                    <label for="tag[]">#Tags <span style="color: red;">*</span></label>
                    @error('tag')<label class="alert-danger">{{ $message }}</label>@enderror
                </div>
                <input type="text" autocomplete="off" id="tag[1]" name="tag[1]" placeholder="beautiful" maxlength="20" class="add-blog__input-tag @error('tag[1]') is-invalid @enderror">
                <input type="text" autocomplete="off" id="tag[2]" name="tag[2]" placeholder="beautiful" maxlength="20" class="add-blog__input-tag @error('tag[2]') is-invalid @enderror">
                <input type="text" autocomplete="off" id="tag[3]" name="tag[3]" placeholder="beautiful" maxlength="20" class="add-blog__input-tag @error('tag[3]') is-invalid @enderror">
                <input type="text" autocomplete="off" id="tag[4]" name="tag[4]" placeholder="beautiful" maxlength="20" class="add-blog__input-tag @error('tag[4]') is-invalid @enderror">
            </div>
        </div>
        <div class="add-blog__header">
            <div class="add-blog__btn-post-wrapper">
                <button class="add-blog__btn-post" type="submit">Post</button>
            </div>
        </div>
    </form>
    </div>
@endsection
