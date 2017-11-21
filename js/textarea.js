$(document).ready(function() {
	var total_characters = $('textarea').attr('maxlength');
	if($('#textarea').val().length <= total_characters && $('#textarea').val().length != 0){
		$('#textarea_feedback').html((total_characters - $('#textarea').val().length) + ' characters remaining');
		if($('#textarea').val().length >= total_characters){
			$('#textarea_feedback').addClass('max');
		} else {
			$('#textarea_feedback').removeClass('max');
		};
	} else {
		$('#textarea_feedback').html(total_characters + ' characters remaining');
	};
	
	$('#textarea').keyup(function() {
		var text_length = $('#textarea').val().length;
		var text_remaining;
		
		if ( text_length > total_characters ) {
			$('#textarea').val() = $('#textarea').val().substring( 0, total_characters );
			return false;
		} else {
			text_remaining = total_characters - text_length;
		};
		
		if(text_remaining <= 10){
			$('#textarea_feedback').addClass('max');
		} else {
			$('#textarea_feedback').removeClass('max');
		};
		
		$('#textarea_feedback').html(text_remaining + ' characters remaining');
	});
});

$(document).ready(function() {
	var total_characters = 120;
	if($('#long').val().length <= total_characters && $('#textarea').val().length != 0){
		$('#textarea_feedback2').html((total_characters - $('#long').val().length) + ' characters remaining');
		if($('#long').val().length >= total_characters){
			$('#textarea_feedback2').addClass('max');
		} else {
			$('#textarea_feedback2').removeClass('max');
		};
	} else {
		$('#textarea_feedback2').html(total_characters + ' characters remaining');
	};
	
	$('#long').keyup(function() {
		var text_length = $('#long').val().length;
		var text_remaining;
		
		if ( text_length > total_characters ) {
			$('#long').val() = $('#long').val().substring( 0, total_characters );
			return false;
		} else {
			text_remaining = total_characters - text_length;
		};
		
		if(text_remaining <= 10){
			$('#textarea_feedback2').addClass('max');
		} else {
			$('#textarea_feedback2').removeClass('max');
		};
		
		$('#textarea_feedback2').html(text_remaining + ' characters remaining');
	});
});