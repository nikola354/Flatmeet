@extends('master.login-master', ['title' => __('Регистрация')])
@section('content')
    <form action="{{route('postSignUp')}}" method="post">
        {{ csrf_field() }}
        <span class="login100-form-title p-b-49">{{__('Регистрация')}}</span>
        <div class="wrap-input100 validate-input m-b-23">
            <span class="label-input100">{{__('Име')}}</span>
            <input class="input100" type="text" name="firstName" value="{{old('firstName')}}" placeholder="{{__('Име')}}">
            <span class="focus-input100" data-symbol="&#xf206;"></span>
        </div>

        <div class="wrap-input100 validate-input m-b-23">
            <span class="label-input100">{{__('Фамилия')}}</span>
            <input class="input100" type="text" name="lastName" value="{{old('lastName')}}" placeholder="{{__('Фамилия')}}">
            <span class="focus-input100" data-symbol="&#xf206;"></span>
        </div>

        <div class="wrap-input100 validate-input m-b-23">
            <span class="label-input100">{{__('Имейл')}}</span>
            <input class="input100" type="text" name="email" value="{{old('email')}}" placeholder="{{__('Имейл')}}">
            <span class="focus-input100" data-symbol="&#xf206;"></span>
        </div>

        <div class="wrap-input100 validate-input">
            <span class="label-input100">{{__('Парола')}}</span>
            <input class="input100" type="password" name="password" placeholder="{{__('Парола')}}">
            <span class="focus-input100" data-symbol="&#xf190;"></span>
        </div>
        <br>
        <div class="wrap-input100 validate-input">
            <span class="label-input100">{{__('Повтори паролата')}}</span>
            <input class="input100" type="password" name="repeatPassword" placeholder="{{__('Повтори паролата')}}">
            <span class="focus-input100" data-symbol="&#xf190;"></span>
        </div>

        <div class="text-right p-t-8 p-b-31">
            <a href="#"></a>
        </div>
        
        <div class="container-login100-form-btn">
            <div class="wrap-login100-form-btn">
                <div class="login100-form-bgbtn"></div>
                <button type="submit" class="login100-form-btn">{{__('Регистрирай се')}}</button>
            </div>
        </div>

        <div class="flex-col-c p-t-155" style="margin-top: -136px">
            <span class="txt1 p-b-17">{{__('Имаш профил')}}?</span>
            <a href="{{route('login')}}">{{__('Влез в профила си')}}</a>
        </div>
    </form>
@endsection