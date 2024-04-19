@extends('master.master', ['title' => __('Съседи')])
@section('content')
    @if(sizeof($neighbors) === 0)
        <h2 class="pageTitle">{{__('Ти си единственият член на това общество')}}.</h2>
    @else
        <h2 class="pageTitle"><b>{{__('Твоите съседи')}}</b></h2>
        <div class="row">
            @foreach($neighbors as $n)
                <div class="col-md-4">
                    <div class="card community-card boxShadow">
                        <div class="card-body pt-5">
                            <img src="{{$n->file_name !== null ? '/uploadedImages/'.$n->file_name : '/images/user.png'}}" width="94" height="94" alt="profile-image" class="profile"/>
                            <h5 class="card-title text-center">{{$n->first_name}} {{$n->last_name}} {{$n->rights === 'admin' ? " - домоуправител" : ""}} {{$n->rights === 'treasurer' ? " - касиер" : ""}}</h5>
                            <hr>
                            <p class="card-text text-center">{{__('Семейство')}} {{$n->family_name}}</p>
                            <p class="card-text text-center">{{__('Етаж')}}: {{$n->floor}}</p>
                            <p class="card-text text-center">{{__('Апартамент')}}: {{$n->ap_num}}</p>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <a href="{{route('messenger', [$building->building_code, Crypt::encrypt($n->id)])}}">
                                        <button class="btn login_btn"><b>{{__('Съобщение')}}</b></button>
                                    </a>
                                </div>
{{--                                todo uncomment the line below to avoid editing rights of admin users--}}
                                {{--   the rights of the neighbor can be changed only if the neighbor is not admin: --}}
{{--                                @if($n->rights !== 'admin')--}}
                                    <div class="col-md-8">
                                        {{--    if the curent user is signed in as treasurer, they can change the rights of a neighbor only to treasurer--}}
                                    @if(auth()->user()->isTreasurer($building->building_code) && $n->rights === 'neighbor')
                                            <select class="btn btn-secondary rightsSelect options"
                                                    data-email="{{$n->email}}" data-code="{{$building->building_code}}">
                                                <option selected>{{__('Промяна на правата')}}</option>
                                                <option value="treasurer">{{__('Касиер')}}</option>
                                            </select>

                                            {{--    if the curent user is signed in as admin, they can change the rights of the neighbor--}}
                                        @elseif(auth()->user()->isAdmin($building->building_code))
                                            <select class="btn btn-secondary rightsSelect options"
                                                    data-email="{{$n->email}}" data-code="{{$building->building_code}}">
                                                <option selected>{{__('Промяна на правата')}}</option>
                                                @if($n->rights !== 'neighbor')
                                                    <option value="neighbor">{{__('Съсед')}}</option>
                                                @endif
                                                @if ($n->rights !== 'treasurer')
                                                    <option value="treasurer">{{__('Касиер')}}</option>
                                                @endif
                                                @if ($n->rights !== 'admin')
                                                    <option value="admin">{{__('Домоуправител')}}</option>
                                                @endif
                                                <option value="kickOut">{{__('Изгонване от входа')}}</option>
                                            </select>
                                        @endif
                                    </div>
{{--                                @endif--}}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
