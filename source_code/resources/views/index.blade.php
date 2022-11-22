@extends('master.login-master', ['title' => 'Flatmeet'])
@section('content')
    <span class="login100-form-title p-b-49">FLATMEET</span>
    <div class="wrap-input100 validate-input m-b-23" style="border-bottom: 0px;">
        <p class="mainPageText">{{('Обедини съседите си в една')}} <span style="color: var(--maincolor)"><b>{{('общност')}}</b></span>!</p>
    </div>

    <div class="row mainPageBtns">
        <div class="col-md-6">
            <a href="{{route('signUp')}}">
                <input type="submit" value="{{('Регистрация')}}" class="btn login_btn">
            </a>
        </div>

        <div class="col-md-6">
            <a href="{{route('login')}}">
                <input type="submit" value="{{('Вход')}}" class="btn login_btn">
            </a>
        </div>
    </div>

    <style>
        .wrap-login100 {
            width: 860px;
        }
    </style>
@endsection