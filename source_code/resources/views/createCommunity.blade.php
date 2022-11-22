@extends('master.master', ['title' => __('Създай общност')])
@section('content')
    <div class="community-card boxShadow joinCommunityBox">
        <div class="card-body pt-5">
            <h3>{{__('Адрес на входа')}}</h3>
            <hr>
            <p>{{__('Въведи адреса на входа си, за да обединиш съседите си в една общност')}}!</p>
            <hr>
            <form method="post" action="{{route('postCreateCommunity')}}">
                {{ csrf_field() }}

                <div class="input-group form-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                    </div>
                    <input type="text" name="shortAddress" class="form-control" value="{{old('shortAddress')}}" placeholder="{{__('Улица и номер   или   квартал и номер на блок')}}">
                </div>

                <div class="input-group form-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    </div>
                    <input type="text" name="fullAddress" class="form-control" value="{{old('fullAddress')}}" placeholder="{{__('Пълен адрес: град, държава, пощенски код...')}}">
                </div>
                <hr>
                <h3>{{__('Информация за домоуправителя')}}</h3>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                            </div>
                            <input type="text" name="apNumber" class="form-control" value="{{old('apNumber')}}" placeholder="{{__('Апартамент')}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                            </div>
                            <input type="text" name="floor" class="form-control" value="{{old('floor')}}" placeholder="{{__('Етаж')}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-8">
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                            </div>
                            <input type="text" name="family" class="form-control" value="{{old('family')}}" placeholder="{{__('Фамилно име (по желание)')}}">
                            <p class="createCommunityP">{{__('Ако не зададеш фамилно име, полето ще бъде запълнено автоматично с твоите имена')}}.</p>
                        </div>
                    </div>
                    <div class="col-md-2">
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <input type="submit" value="{{__('Създай')}}" class="btn float-right login_btn">
                </div>
            </form>
        </div>
    </div>
@endsection