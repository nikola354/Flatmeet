@extends('master.messenger-master', ['title' => __('Съобщения')])
@section('content')
	<div id="frame">
		<div id="dmUser" style="display: none;">{{$contact}}</div>
	    <div id="sidepanel" class="sideMessengerMenu">
	        <div id="profile" data-id="{{auth()->user()->id}}" data-email="{{auth()->user()->email}}" data-building_code="{{$building->building_code}}">
	            <div class="wrap">
	                <img id="profile-img" src="{{auth()->user()->file_name !== null ? '/uploadedImages/'.auth()->user()->file_name : '/images/user-circle-solid.svg'}}" alt="" />
	                <p>{{auth()->user()->first_name.' '.auth()->user()->last_name}}</p>
	            </div>
	        </div>

	        <div id="search">
	            <label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
	            <input type="text" placeholder="{{__('Търси в контакти...')}}" />
	        </div>

	        <div id="contacts">
	            <ul>
	            	@foreach($contacts as $c)
	            		<li class="contact {{($contact === $c->contact_id) ? 'active' : ''}}" data-id="{{$c->contact_id}}">
	            			<div class="wrap">
	            				<span id="seen" style="{{($c->hasUnseenMessages && $c->message !== null) ? '' : 'display: none;'}}"></span>
	            				<img id="contactProfilePic" src="{{$c->contact_file_name !== null ? '/uploadedImages/'.$c->contact_file_name : '/images/user-circle-solid.svg'}}" alt="" />
	            				<div class="meta">
	            					<p class="name">{{$c->contact_first_name.' '.$c->contact_last_name}}</p>
	            					<p class="preview">{!!$c->sender === auth()->user()->id ? '<span id="lastSender">Вие:</span>' : ''!!}<span style="opacity: 1;">{{$c->message}}</span></p>
	            				</div>
	            			</div>
	            		</li>
	            	@endforeach
	            </ul>
	        </div>

	        <div id="bottom-bar">
	        	<div class="row">
					@if(sizeof($contacts) !== 0)
						<div class="col-md-6">
							<button id="messageToAll"><i class="far fa-envelope"></i> <span>{{__('Съобщение до всички')}}</span></button>
						</div>

						<div class="col-md-6">
			            	<button id="openSideMenu"><i class="fas fa-bars"></i> <span>{{__('Меню')}}</span></button>
					    </div>
					@else
			            <div class="col-md-12">
			            	<button id="openSideMenu"><i class="fas fa-bars"></i> <span>{{__('Меню')}}</span></button>
					    </div>
					@endif
			    </div>
			</div>
	    </div>

	    <div id="sideMenu">
	    	<nav id="sidebar">
		    	<a href="{{route('dashboard')}}">
			        <div class="img bg-wrap text-center py-4" style="background-image: url('../../images/background.jpg');">
			            <div class="user-logo">
			                <h2 style="color: orange; cursor: pointer; user-select: none;"><b>Flatmeet</b></h2>
			            </div>
			        </div>
			    </a>

			    <ul class="list-unstyled components mb-5">
		            {{--navigation when logged in a community--}}
		            @if(auth()->user()->isAdmin($building->building_code))
		                <li>
		                    <a href="{{route('waitingRoom', $building->building_code)}}"><span class="fa mr-3"></span>{{__('Чакалня')}}</a>
		                </li>
		                <hr>
		            @elseif(auth()->user()->isTreasurer($building->building_code))
		                <li>
		                    <a href="{{route('addPayment', $building->building_code)}}"><span class="fa mr-3"></span>{{__('Добави разход')}}</a>
		                </li>
		                <hr>
		            @endif
		            <li>
		                <a href="{{route('neighbors', $building->building_code)}}"><span class="fa mr-3"></span>{{__('Съседи')}}
		                </a>
		            </li>
		            <li>
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
	        </nav>

	        <div id="bottom-bar">
	            <button id="closeSideMenu"><i class="fas fa-bars"></i> <span>{{__('Меню')}}</span></button>
	        </div>
	    </div>

	    <div class="content" style="display: none">
	        <div class="contact-profile">
	            <img src="" id="contactPic" alt="" />
	            <p id="contactName"></p>
	        </div>

	        <div class="messages">
	            <ul>
	            </ul>
	        </div>
	        
	        <div class="message-input">
	            <div class="wrap">
	                <input type="text" id="message" placeholder="{{__('Твоето съобщение...')}}" />
	                <button class="submit" id="sendMessage"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
	            </div>
	        </div>
	    </div>
	</div>

	<div id="messageToAllModal" class="modal fade">
	    <div class="modal-dialog modal-confirm">
	        <div class="modal-content">
	            <div class="modal-header justify-content-center" style="background: var(--maincolor)">
	                <div class="icon-box">
	                    <i class="fas fa-info" style=" font-size: 50px; margin:0 0 5px 2px;"></i>
	                </div>
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	            </div>
	            <div class="modal-body text-center">
	                <h4>{{__('Съобщението ще бъде изпратено до всички потребители')}}!</h4>
	                <input type="text" class="form-control" id="messageAll"><br>
	                <button class="btn btn-success" type="button" id="sendMessageToAll">{{__('Изпрати')}}</button>
	            </div>
	        </div>
	    </div>
	</div>
@endsection