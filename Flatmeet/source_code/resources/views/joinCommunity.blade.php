@extends('master.master', ['title' => __('Присъединяване')])
@section('content')
    <div class="community-card boxShadow joinCommunityBox">
        <div class="card-body pt-5">
            <h3>{{__('Присъедини се към общността на своите съседи')}}</h3>
            <hr>
            <p>{{__('Въведи 6-цифрения код, който си получил от домоуправителя или администратора на своя вход')}}.</p>
            <hr>
            <div class="row" id="inputCode">
                <div class="col-md-9">
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><b>1</b></span>
                        </div>
                        <input type="text" name="code" class="form-control"
                               placeholder="{{__('6-цифрен код')}}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="submit" disabled value="{{__('Проверка')}}" class="btn float-right login_btn">
                    </div>
                </div>
            </div>
            <div class="row" id="inputApNum">
                <div class="col-md-9">
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text disabled"><b>2</b></span>
                        </div>
                        <input disabled type="text" name="code" class="form-control"
                               placeholder="{{__('Номер на апартамент')}}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <input disabled type="submit" value="{{__('Проверка')}}" class="btn float-right login_btn">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4" id="inputFloor">
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text disabled"><b>3</b></span>
                        </div>
                        <input disabled type="text" name="code" class="form-control" placeholder="{{__('Етаж')}}">
                    </div>
                </div>
                <div class="col-md-8" id="inputFamily">
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text disabled"><b>4</b></span>
                        </div>
                        <input disabled type="text" name="code" class="form-control"
                               placeholder="{{__('Фамилно име (по желание)')}}">
                    </div>
                </div>
            </div>
            <p id="explanationText"></p>
            <hr>

            <div class="form-group">
                <input id="clearBtn" type="submit" value="{{__('Изчистване')}}" class="btn float-left login_btn">

                <input disabled id="joinBtn" type="submit" value="{{__('Присъединяване')}}" class="btn float-right login_btn">
            </div>
        </div>
    </div>
@endsection
