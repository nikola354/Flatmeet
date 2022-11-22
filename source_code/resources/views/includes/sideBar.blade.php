<nav id="sidebar" data-id="{{auth()->user()->id}}">
    <a href="{{isset($building) ? route('mainPage', $building->building_code) : route('dashboard')}}">
        <div class="img bg-wrap text-center py-4" style="background-image: url('../../../../../../images/sunset.jpg');">
            <div class="user-logo">
                <h2 style="color: orange; cursor: pointer; user-select: none;"><b>Flatmeet</b></h2>
            </div>
        </div>
    </a>

    <ul class="list-unstyled components mb-5">
        @if(isset($building))
            {{--navigation when logged in a community--}}
            @if(auth()->user()->isAdmin($building->building_code))
                <li class="{{(Request::segment(2) === 'waiting') ? 'active' : ''}}">
                    <a href="{{route('waitingRoom', $building->building_code)}}"><span class="fa mr-3"></span>{{__('Чакалня')}}</a>
                </li>
                <hr>
            @elseif(auth()->user()->isTreasurer($building->building_code))
                <li class="{{(Request::segment(2) === 'add') ? 'active' : ''}}">
                    <a href="{{route('addPayment', $building->building_code)}}"><span class="fa mr-3"></span>{{__('Добави разход')}}</a>
                </li>
                <hr>
            @endif
            <li class="{{(Request::segment(2) === 'neighbors') ? 'active' : ''}}">
                <a href="{{route('neighbors', $building->building_code)}}"><span class="fa mr-3"></span>{{__('Съседи')}}
                </a>
            </li>
            <li class="{{(Request::segment(2) === 'payments') ? 'active' : ''}}">
                <a href="{{route('payments', $building->building_code)}}"><span class="fa mr-3"></span>{{__('Общи разходи')}}</a>
            </li>
            <li class="{{(Request::segment(2) === 'messenger') ? 'active' : ''}}">
                <a href="{{route('messenger', $building->building_code)}}"><span class="fa mr-3"><div class="ellipse" style="display: none;"></div></span>{{__('Съобщения')}}
                </a>
            </li>
            <hr>
            <li>
                <a href="{{route('dashboard')}}"><span class="fa mr-3"></span>{{__('Всички общности')}}</a>
            </li>
        @else
            {{--navigation before logging in a community--}}
            <li class="{{(Request::segment(1) === 'dashboard') ? 'active' : ''}}">
                <a href="{{route('dashboard')}}"><span class="fa mr-3"></span>{{__('Всички общности')}}</a>
            </li>
            <li class="{{(Request::segment(1) === 'create') ? 'active' : ''}}">
                <a href="{{route('createCommunity')}}"><span class="fa mr-3"></span>{{__('Създай общност')}}</a>
            </li>
            <li class="{{(Request::segment(1) === 'join') ? 'active' : ''}}">
                <a href="{{route('joinCommunity')}}"><span class="fa mr-3"></span>{{__('Присъедини се към общност')}}
                </a>
            </li>
        @endif
    </ul>

    <div class="btn-group menuSettings">
        <img src="{{auth()->user()->file_name !== null ? '/uploadedImages/'.auth()->user()->file_name : '/images/user-circle-regular.svg'}}" class="circularProfilePic" width="42" height="42">
        <p style="width: 135px; word-break: break-word;">{{auth()->user()->first_name.' '.auth()->user()->last_name.(isset($building) ? ' ('.__(auth()->user()->getRights($building->building_code)).')' : '')}}</p>
        <div style="width: 20%; position: relative;"><img class="menuArrow" src="/images/angle-right.svg" width="52" height="20"></div>
        <ul class="list-unstyled components mb-5" style="min-width: 296px;">
            <li class="{{(Request::segment(1) === 'profile') ? 'active' : ''}}">
                <a href="{{route('profileSettings')}}"><span class="fa mr-3"></span>{{__('Профил')}}</a>
            </li>
            <li class="{{(Request::segment(1) === 'change') ? 'active' : ''}}">
                <a href="{{route('changePassword')}}"><span class="fa mr-3"></span>{{__('Смени паролата')}}</a>
            </li>
            <li>
                <a href="{{route('logOut')}}"><span class="fa mr-3"></span>{{__('Изход')}}</a>
            </li>
        </ul>
    </div>
</nav>

<script>
    $(document).ready(function(){
        $('.menuSettings').on('click', function(){
            $('.menuSettings ul').toggle(function(){
                $(this).addClass('visible');
            }, function(){
                $(this).removeClass('visible');
            });
        });
    });
</script>