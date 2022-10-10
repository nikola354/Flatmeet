<!DOCTYPE html>
<html lang="bg">
	@include('includes.login-header')
	<body>
		<div class="loginPage">
			<div class="container-login100" style="background-image: url('/images/sunset.jpg');">
				<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
		            @yield('content')	
		        </div>
		    </div>
		</div>
        @include('includes.messages')
    </body>
</html>