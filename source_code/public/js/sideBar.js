$(document).ready(function(){
	let width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
	$('#sideMenuBtn').on('click', function(){
		$('#sidebar').css('margin-left', '0px');
	});

	$('body').on('click', function(e){
		if(e.target.id !== 'sideMenuBtn' && !($(e.target).parents().closest('#sidebar').length || e.target.id === 'sidebar') && width <= 990){
			$('#sidebar').css('margin-left', '-300px');
		}
	});
});