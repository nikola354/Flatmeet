@extends('master.master', ['title' => __('Чакалня')])
@section('content')
    <div class="pageTitle">
        <h2>{{__('Ти си домоуправителят на този вход')}}.</h2>
        <h2>{{__('Съседите ти могат да се присъединят към общността, като се регистрират и въведат кода')}}:</h2>
        <h2><a id="codeToCopy" href="#">{{$building->building_code}}</a></h2>
        <p hidden id="clickToCopyText">{{__('Кликни, за да копираш кода')}}</p>
    </div>
    @if(sizeof($pendings) === 0)
        <br>
        <hr>
        <h2 class="pageTitle"><i>{{__('Няма нови заявки за присъединяване')}}</i></h2>
    @else
        <div class="row">
            @foreach($pendings as $p)
                <div class="col-md-4">
                    <div class="card community-card boxShadow">
                        <div class="card-body pt-5">
                            <img src="/images/user.png" alt="profile-image" class="profile"/>
                            <h5 class="card-title text-center">{{$p->first_name}} {{$p->last_name}}</h5>
                            <hr>
                            <p class="card-text text-center">{{__('Семейство')}} {{$p->family_name}}</p>
                            <p class="card-text text-center">{{__('Етаж')}}: {{$p->floor}}</p>
                            <p class="card-text text-center">{{__('Апартамент')}}: {{$p->ap_num}}</p>
                            <hr>
                            <div class="form-group">
                                <a href="{{route('markAsDenied', [$building->building_code, $p->email])}}">
                                    <button class="btn btn-danger"><b>{{__('Отказване')}}</b></button>
                                </a>

                                <a href="{{route('markAsAccepted', [$building->building_code, $p->email])}}">
                                    <button class="btn btn-success float-right"><b>{{__('Одобряване')}}</b></button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection