@extends('master.master', ['title' => __('Общности')])
@section('content')
    @if(empty($buildings))
        {{--    if the user does not have communities: --}}
        <div class="noCommunitiesPage">
            <div class="firstOption">
                <h4 class="pageTitle"><b>{{__('Все още не членуваш в общност')}}</b></h4>
                <a href="{{route('logOut')}}">{{__('Опитай с друг профил')}}</a>
            </div>
            <div class="orOption">
                <p><b>{{__('ИЛИ')}}</b></p>
            </div>
            <div class="secondOption">
                <h4 class="pageTitle"><b>{{__('Създай първата си общност или се присъедини към такава')}}</b></h4>
                <a style="margin-left: -10px; margin-right: 20px"
                   href="{{route('createCommunity')}}">{{__('Създаване')}}</a>
                <a href="{{route('joinCommunity')}}">{{__('Присъединяване')}}</a>
            </div>
        </div>
    @else
        <h2 class="pageTitle"><b>{{__('Общности')}}</b></h2>
        <form>
            <div class="row">
                @foreach($buildings as $b)
                    <div class="col-md-4">
                        <div class="card community-card boxShadow">
                            <a href="{{route('mainPage', $b->building_code)}}">
                                <div class="card-body pt-5">
                                    <img src="/images/house.jpg" alt="profile-image" class="profile"/>
                                    <h5 class="card-title text-center">{{$b->short_address}}</h5>
                                    <hr>
                                    <p class="card-text text-center">{{$b->full_address}}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </form>
    @endif
@endsection
