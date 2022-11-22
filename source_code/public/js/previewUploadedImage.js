let reader = new FileReader(); // file reader for previewing uploaded images

$(document).ready(function(){
	$('#imgInput').change(function(){
		previewImage(this);
	});
});

function previewImage(input) {
	if(input.files && input.files[0]){
		reader.onload = function(e) {
			$('#pictureToShow').attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]); // convert to base64 string
	}
}