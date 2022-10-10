@extends('master.login-master', ['title' => __('Вход')])
@section('content')
    <form class="login100-form validate-form" action="{{route('postLogin')}}" method="post">
        {{ csrf_field() }}
        <span class="login100-form-title p-b-49">{{__('Вход')}}</span>
        <div class="wrap-input100 validate-input m-b-23">
            <span class="label-input100">{{__('Имейл')}}</span>
            <input class="input100" type="text" name="email" placeholder="{{__('Имейл')}}">
            <span class="focus-input100" data-symbol="&#xf206;"></span>
        </div>

        <div class="wrap-input100 validate-input">
            <span class="label-input100">{{__('Парола')}}</span>
            <input class="input100" type="password" name="password" placeholder="{{__('Парола')}}">
            <span class="focus-input100" data-symbol="&#xf190;"></span>
        </div>

        <div class="text-right p-t-8 p-b-31">
        </div>
        
        <div class="container-login100-form-btn">
            <div class="wrap-login100-form-btn">
                <div class="login100-form-bgbtn"></div>
                <button type="submit" class="login100-form-btn">{{__('Влез')}}</button>
            </div>
        </div>

        <div class="flex-col-c p-t-155">
            <span class="txt1 p-b-17">{{__('Нямаш профил')}}?</span>
            <a href="{{route('signUp')}}">{{__('Регистрирай се')}}</a>
        </div>
    </form>
@endsection