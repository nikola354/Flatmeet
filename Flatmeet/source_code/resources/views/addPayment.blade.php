@extends('master.master', ['title' => __('Добави общ разход')])
@section('content')
    <div class="row">
        <div class="community-card boxShadow joinCommunityBox" id="addPaymentBox">
            <div class="card-body pt-5">
                <h3>{{__('Добави нов месечен разход на входа')}}</h3>
                <hr>
                <p>{{__('Избери вида на разхода, месеца, за който се отнася, и начина, по който искаш да го поделиш между своите съседи')}}.</p>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <p>{{__('Брой апартаменти')}}: {{count($apartments)}}</p>
                    </div>
                    <div class="col-md-6">
                        <p>{{__('Брой живущи')}}: {{$inhabitantsNum}}</p>
                    </div>
                </div>
                <hr>
                <form action="{{route('postAddPayment', $building->building_code)}}" enctype="multipart/form-data" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-3">
                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><b>1</b></span>
                                </div>
                                <select id="selectType" name="paymentType">
                                    <option value="default" selected>{{__('Вид разход')}}</option>
                                    @foreach($paymentsTypes as $p)
                                        <option value="{{$p->id}}">{{$p->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><b>2</b></span>
                                </div>
                                <input name="month" type="month" min="{{$minMonth}}" max="{{$maxMonth}}" value="{{$curMonth}}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><b>3</b></span>
                                </div>
                                <input type="number" placeholder="{{__('Сума')}}" step="0.01" name="price"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><b>4</b></span>
                                </div>
                                <select id="selectShare">
                                    <option value="default" selected>{{__('Начин на разпределяне')}}</option>
                                    <option value="amongApartments">{{__('Поравно между апартаментите')}}</option>
                                    <option value="amongInhabitants">{{__('Поравно между всички живущи')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <img width="100" height="100" src="/images/receipt.svg" id="pictureToShow" alt="">
                    <label class="uploadPicture btn">
                        <input type="file" name="fileName[]" id="imgInput">
                        <b>{{__('Качи снимка')}}</b>
                    </label>
                    <p>{{__('Добави снимка на касова бележка или разписка, за да изглежда разходът по-достоверен. (по желание)')}}</p>
                    <hr>
                    <div class="row apPills" data-number="{{$inhabitantsNum}}">
                        @foreach($apartments as $a)
                            <div class="apPill" hidden data-inhabitants="{{$a->inhabitants}}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5><b>{{$a->family_name}}</b></h5>
                                        <p><b>{{__('Ет.')}} {{$a->floor}} {{__('Ап.')}} {{$a->number}}</b></p>
                                        <p><b>{{__('Живущи')}}: {{$a->inhabitants}}</b></p>
                                    </div>
                                    <div class="col-md-6 apPrice">
                                        <input name="ap{{$a->number}}" step="0.01" type="number" />
                                        <p>{{__('Сума за плащане')}}:</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <p id="warningText"></p>
                    <hr>
                    <div class="form-group">
                        <input disabled id="addPaymentBtn" type="submit" value="{{__('Добавяне')}}"
                               class="btn float-right login_btn">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection