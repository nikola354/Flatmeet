<!DOCTYPE html>
<html lang="bg">
    @include('includes.header')
    @include('includes.messages')
    <body style="background-color: rgba(232,242,237,0.86) !important;">
        <div class="wrapper d-flex align-items-stretch">
            @include('includes.sideBar')
            <div id="content" class="p-4 p-md-5 pt-5">
                <div class="responsiveMenuBox">
                    <i class="fas fa-bars" style="margin-left: 20px;" id="sideMenuBtn"></i>
                    <h1 class="responsiveMenuText">{{__('Меню')}}</h1>
                </div>
                @yield('content')
            </div>
        </div>
    </body>
</html>