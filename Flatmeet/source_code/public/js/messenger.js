Pusher.logToConsole = true; // turn off when in production

let buildingCode = '';
let email = '';
let input = ''; // search input
let title = '';
let authID = 0;
let from = 0;
let to = 0;
let selected = 0;
let canSend = false;
let searching = false;
let users = []; // users' ids whose messages are not yet seen by the auth user
let contacts = [];

Echo.join('flatmeet-chat').listen('MessageSent', (data) => {
	if(authID === data.recipient.id){
		if(searching){
			if(!users.includes(data.user.id)) users.push(data.user.id);
		}else{
			if(selected == data.user.id){
				appendMessage(data.message.body, ((data.message.from === authID) ? 'replies' : 'sent'), data.user.file_name);
				$(`.contact[data-id = ${data.user.id}]`).find('.preview').html(data.message.body);
				makeSeen(data.user.id);
			}else{
				if(!users.includes(data.user.id)) users.push(data.user.id);

				$(`.contact[data-id = ${data.user.id}]`).remove();
				listContacts(data.user.id, data.user.first_name + ' ' + data.user.last_name, data.user.file_name, data.message.body, data.user.id, 'prepend');
			}
		}
	}
});

$(document).ready(function(){
	let dmID = $('#dmUser').html();
	let width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
	title = document.title;
	buildingCode = $('#profile').data('building_code');
	email = $('#profile').data('email');
	authID = $('#profile').data('id');
	from = authID;
	
	getUnSeenMessages();

	if(dmID !== ''){
		to = dmID;
		selected = to;
		canSend = true;
		$('#message').focus();
		$('#contactName').html($(`.contact[data-id = ${dmID}]`).find('.name').html());
		$('#contactPic').html($(`.contact[data-id = ${dmID}]`).find('#contactProfilePic').html());
		fetchMessages(from, dmID);
	}

	$('#contacts ul').children().each(function(){
		let id = $(this).data('id');
		let name = $(this).find('.name').html();
		let file_name = $(this).find('#contactProfilePic').attr('src');
		contacts.push({id: id, name: name, file_name: file_name});
	});

	$('#openSideMenu').on('click', function(){
		let menu = $('#frame').find('#sideMenu');
		if(width <= 990){
			menu.css('margin-left', '-60px');
			$('.content').css('display', 'none');
			$('#contacts ul').find('.active').removeClass('active');
			selected = 0;
			to = 0;
		}else{
			menu.css('margin-left', '-18.8rem');
		}
		menu.addClass('activeSideMenu');
	});

	$('#closeSideMenu').on('click', function(){
		let menu = $('#frame').find('#sideMenu');
		menu.css('margin-left', '-40rem');
		menu.removeClass('activeSideMenu');
	});

	Echo.connector.pusher.connection.bind('state_change', function(state){
		if(state.current === 'unavailable' || state.current === 'disconnected'){
			errorModal('Възникна някакъв проблем с връзката!');
		}
	});

	$('body').on('click', function(e){
		if(e.target.id === 'message' || $(e.target).hasClass('contact') || $(e.target).parents().closest('.contact').length){
			canSend = true;
			$('#message').focus();
		}else{
			canSend = false;
		}
	});

	$(document).on('keydown', function(e){
		// enter pressed
		if(e.which == 13 && canSend){
			sendMessage();
		}
	});

	$('#search input').on('keyup', function(){
		if(input.length !== $(this).val().toLowerCase().length){
			searching = true;
			input = $(this).val().toLowerCase();

			if(!input.length){
				reloadContacts();
				searching = false;
				to = 0;
				selected = 0;
			}else if(input.trim().length){
				clear();
				let filtered = contacts.filter(filterByName);
				$('#contacts ul').empty();

				for(f in filtered){
					let cont = filtered[f];
					listContactsSearch(cont.id, cont.name, cont.file_name);
				}
			}
		}
	});

	$('#contacts ul').on('click', '> *', function(){
		if(searching){
			searching = false;
			input = '';
			to = $(this).data('id');
			selected = to;
			clear();
			reloadContacts();
			$('#search input').val('');
			$('#contactName').html($(this).find('.name').html());
			fetchMessages(from, to);
		}else if(!$(this).hasClass('active')){
			$('.messages ul').empty();
			$('#contacts ul').find('.active').removeClass('active');
			$('#contactName').html($(this).find('.name').html());
			$(this).addClass('active');
			to = $(this).data('id');
			selected = to;
			fetchMessages(from, to);
		}
	});

	$('#sendMessage').on('click', function(){
		sendMessage();
	});

	$('#messageToAll').on('click', function(){
		let modal = $('#messageToAllModal');
		modal.modal('show');

		$('#sendMessageToAll').on('click', function(){
			let message = $('#messageAll').val();
			$('#sendMessageToAll').prop('disabled', true);
			$.ajax({
				method: 'POST',
				url: '/post/send/message/all',
				data: {
					'from': from,
					'buildingCode': buildingCode,
					'message': message,
					'_token': token
				},
				success: (data) => {
					modal.modal('hide');
					$('#messageAll').val('');
					$('#sendMessageToAll').prop('disabled', false);
					if(data.status === 200){
						reloadContacts();
						if(selected) appendMessage(message, 'replies', data.user.file_name);
					}else{
						errorModal('Възникна някаква грешка!');
					}
				},
				error: (err) => {
					modal.modal('hide');
					$('#messageAll').val('');
					$('#sendMessageToAll').prop('disabled', false);				

					errorModal('Възникна някаква грешка!');
				}
			});
		});
	});
});

function sendMessage(){
	let message = $('#message').val();
	if(!message.trim()) return;
	
	$.ajax({
		method: 'POST',
		url: '/post/save/message',
		data: {
			'from': from,
			'to': to,
			'message': message,
			'_token': token
		},
		success: (data) => {
			appendMessage(message, 'replies', data.user.file_name);
			$('#message').val('');
			input = '';
			$(`.contact[data-id = ${data.recipient.id}]`).remove();
			listContacts(data.recipient.id, data.recipient.first_name + ' ' + data.recipient.last_name, data.recipient.file_name, message, data.user.id, 'prepend');

			$(`.contact[data-id = ${data.recipient.id}]`).addClass('active');
		},
		error: (err) => {
			errorModal('Възникна някаква грешка!');
		}
	});
}

function fetchMessages(from, to){
	$.ajax({
		method: 'POST',
		url: '/post/fetch/messages',
		data: {
			'from': from,
			'to': to,
			'_token': token
		},
		success: (data) => {
			let hasUnseen = false;
			let msgLen = 0;

			for(d in data){
				let message = data[d];
				msgLen += message.body.length;
				if(message.from !== authID && !message.seen) hasUnseen = true;
				let type = (message.from === authID) ? 'replies' : 'sent';
				appendMessage(message.body, type, message.file_name);
			}

			if(hasUnseen){
				makeSeen(to); // 'to' refers to the contact's id 
			}

			$('.content').css('display', 'block');
			$('.messages').scrollTop(msgLen * 60);
		},
		error: (err) => {
			errorModal('Възникна някаква грешка!');
		}
	});
}

function makeSeen(from){
	$.ajax({
		method: 'POST',
		url: '/post/messages/seen',
		data: {
			'from': from,
			'_token': token
		},
		success: () => {
			$(`.contact[data-id = ${to}]`).find('#seen').css('display', 'none');
			for(i in users){
				let id = users[i];
				if(id === from){
					users.splice(i, 1);
					break;
				}
			}
		},
		error: (err) => {
			errorModal('Възникна някаква грешка!');
		}
	});
}

function getUnSeenMessages(){
	$.ajax({
		method: 'POST',
		url: '/post/count/unseen',
		data: {
			'_token': token
		},
		success: (data) => {
			users = data;
			let tik = setInterval(updateTitle, 1000);
		},
		error: (err) => {
			errorModal('Възникна някаква грешка!');
		}
	});
}

function appendMessage(message, type, fileName){
	let html = `<li class="${type}"><img src="${fileName !== null ? '/uploadedImages/' + fileName : '/images/user-circle-solid.svg'}" alt="" /><p>${message}</p></li>`;
	$('.messages ul').append(html);
	$('.messages')[0].scrollTop += message.length * 60;
}

function listContacts(id, name, fileName, message, sender, action = 'append', seen = false){
	let span = (sender === authID) ? '<span id="lastSender">Вие:</span>' : '';
	let display = (sender === authID || seen) ? 'none' : 'block';
	let html = `<li class="contact" data-id="${id}"><div class="wrap"><span id="seen" style="display: ${display};"></span><img id="contactProfilePic" src="${fileName !== null ? '/uploadedImages/' + fileName : '/images/user-circle-solid.svg'}" alt="" /><div class="meta"><p class="name">${name}</p><p class="preview">${span}<span style="opacity: 1;">${message}</span></p></div></div></li>`;
	
	if(action === 'append') $('#contacts ul').append(html);
	else if(action === 'prepend') $('#contacts ul').prepend(html);
}

function listContactsSearch(id, name, fileName){
	let html = `<li class="contact" data-id="${id}"><div class="wrap"><span id="seen" style="display: none;"></span><img id="contactProfilePic" src="${fileName}" alt="" /><div class="meta"><p class="name">${name}</p><p class="preview"><span style="opacity: 1;"></span></p></div></div></li>`;
	$('#contacts ul').append(html);
}

function reloadContacts(){
	$.ajax({
		method: 'POST',
		url: '/post/fetch/contacts/' + buildingCode,
		data: {
			'email': email,
			'_token': token
		},
		success: (data) => {
			$('#contacts ul').empty();
			for(d in data){
				let obj = data[d];
				listContacts(obj.contact_id, obj.contact_first_name + ' ' + obj.contact_last_name, obj.contact_file_name, (obj.message === null ? '' : obj.message), obj.sender, 'append', true);
			}

			$('#contacts ul').children().each(function(index){
				let id = $(this).data('id');
				let name = $(this).find('.name').html();
				let file_name = $(this).find('#contactProfilePic').attr('src');
				contacts[index] = {id: id, name: name, file_name: file_name};
			});

			$(`.contact[data-id = ${to}]`).addClass('active');
		},
		error: (err) => {
			errorModal('Възникна някаква грешка!');
		}
	});
}

function errorModal(msg){
	$('#jsonErrorsModal').find('.errorContent p').html(msg);
	$('#jsonErrorsModal').modal('show');
}

function updateTitle(){
	if(document.title === title && users.length) document.title = title + ' (' + users.length + ')';
	else document.title = title;

	if(users.length){
		$('#sidebar ul').find('.ellipse').css('display', 'block');
		$('#sidebar ul').find('.ellipse').html(users.length);
	}else{
		$('#sidebar ul').find('.ellipse').css('display', 'none');
	}
}

function clear(){
	$('#contactPic').empty();
	$('#contactName').empty();
	$('.messages ul').empty();
}

function filterByName(item){
	let firstName = item.name.substring(0, item.name.indexOf(' ')).toLowerCase();
	let lastName = item.name.substring(item.name.indexOf(' ') + 1, item.name.length).toLowerCase();
	let in1 = input.substring(0, input.indexOf(' '));
	let in2 = input.substring(input.indexOf(' ') + 1, input.length);

	return ((((firstName.indexOf(in1) > -1 || lastName.indexOf(in1) > -1) && in1 !== '') || in1 === '') && (((firstName.indexOf(in2) > -1 || lastName.indexOf(in2) > -1) && in2 !== '') || in2 === ''));
}