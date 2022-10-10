@extends('master.master', ['title' => __('Профил')])
@section('content')
    <div class="wrapperBox bg-white mt-sm-5">
    <h4 class="pb-4 border-bottom">{{__('Настройки на профила')}}</h4>
    <form action="{{route('changeProfileSettings')}}" enctype="multipart/form-data" method="post">
        {{ csrf_field() }}
        <div class="d-flex align-items-start py-3 border-bottom">
            <img src="{{$fileName !== null ? '/uploadedImages/'.$fileName : '/images/user.png'}}" class="profilePicture" id="pictureToShow" alt="">
            <div class="pl-sm-4 pl-2" id="img-section"> <b>{{__('Профилна снимка')}}</b>
                <p></p>
                <label class="uploadPicture btn">
                    <input type="file" name="fileName[]" id="imgInput">
                    <b>{{__('Качи снимка')}}</b>
                </label>
            </div>
        </div>

        <div class="py-2">
            <p>{{__('Име')}}</p>
            <div class="input-group form-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" name="firstName" class="form-control" value="{{$firstName}}" placeholder="{{__('Име')}}">
            </div>
            <br>

            <p>{{__('Фамилно име')}}</p>
            <div class="input-group form-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" name="lastName" class="form-control" value="{{$lastName}}" placeholder="{{__('Фамилно име')}}">
            </div>
            <br>

            <div class="form-group">
                <input type="submit" value="{{__('Запази промените')}}" class="btn float-right login_btn">
            </div>
            <br>
        </div>
    </form>
</div>
@endsection