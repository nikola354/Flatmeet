let users = []; // users' ids whose messages are not yen seen by the auth user
let authID = 0;

Echo.join('flatmeet-chat').listen('MessageSent', (data) => {
	if(data.recipient.id === authID){
		if(!users.includes(data.user.id)){
			users.push(data.user.id);
			$('#sidebar ul').find('.ellipse').css('display', 'block');
			$('#sidebar ul').find('.ellipse').html(users.length);
		}
	}
});

Echo.join('flatmeet-chat').listen('MessageSeen', (data) => {
	if(data.recipientID === authID){
		for(i in users){
			let id = users[i];
			if(id === data.senderID){
				users.splice(i, 1);

				if(users.length){
					$('#sidebar ul').find('.ellipse').css('display', 'block');
					$('#sidebar ul').find('.ellipse').html(users.length);
				}else{
					$('#sidebar ul').find('.ellipse').css('display', 'none');		
				}
				break;
			}
		}
	}
});

$(document).ready(function(){
	authID = $('#sidebar').data('id');

	$.ajax({
		method: 'POST',
		url: '/post/count/unseen',
		data: {
			'_token': token
		},
		success: (data) => {
			users = data;
			if(data.length){
				$('#sidebar ul').find('.ellipse').css('display', 'block');
				$('#sidebar ul').find('.ellipse').html(data.length);
			}
		}
	})
});
