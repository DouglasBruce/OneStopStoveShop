//Determines which nav element is active
$(document).ready(function(){
	$("#home a:contains('Home')").parent().addClass('active');
	$("#about a:contains('About')").parent().addClass('active');
	$("#contact a:contains('Contact')").parent().addClass('active');
	$("#store a:contains('Store')").parent().addClass('active');
	$("#registration a:contains('Register')").parent().addClass('active');
	$("#login a:contains('Login')").parent().addClass('active');
	$("#account a:contains('Account')").parent().addClass('active');
	$("#admin a:contains('Admin')").parent().addClass('active');
	$("#cart a:contains('Cart')").parent().addClass('active');
	$("#installations a:contains('Installations')").parent().addClass('active');
	
	$('ul.nav li.dropdown').hover(function(){
		$('.dropdown-menu', this).fadeIn();
	}, function(){
		$('.dropdown-menu', this).fadeOut('fast');
	});
});

/**
 * Vertically center Bootstrap 3 modals so they aren't always stuck at the top
 */
$(function() {
    function reposition() {
        var modal = $(this),
            dialog = modal.find('.modal-dialog');
        modal.css('display', 'block');
        
        // Dividing by two centers the modal exactly, but dividing by three 
        // or four works better for larger screens.
        dialog.css("margin-top", Math.max(0, ($(window).height() - dialog.height()) / 2));
    }
    // Reposition when a modal is shown
    $('.modal').on('show.bs.modal', reposition);
    // Reposition when the window is resized
    $(window).on('resize', function() {
        $('.modal:visible').each(reposition);
    });
});

$('body').prepend('<a href="#" class="back-to-top"></a>');
			
var amountScrolled = 300;

$(window).scroll(function() {
	if ( $(window).scrollTop() > amountScrolled ) {
		$('a.back-to-top').fadeIn('slow');
	} else {
		$('a.back-to-top').fadeOut('slow');
	}
});

$('a.back-to-top').click(function() {
	$('html, body').animate({
		scrollTop: 0
	}, 700);
	return false;
});

$('textarea').on('paste input', function () {
	if ($(this).outerHeight() > this.scrollHeight){
		$(this).height(1)
	}
	while ($(this).outerHeight() < this.scrollHeight + parseFloat($(this).css("borderTopWidth")) + parseFloat($(this).css("borderBottomWidth"))){
		$(this).height($(this).height() + 1)
	}
});

bootstrap_alert = function() {}
bootstrap_alert.warning = function(message) {
	$('#alert_placeholder').html('<div class="alert alert-success fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><span>'+message+'</span></div>')
}

$('#clickme').on('click', function() {
	bootstrap_alert.warning('Review Deleted!');
});

jQuery(document).ready(function(){
	jQuery('#open-review-box').on('click', function(event) {        
		jQuery('#post-review-box').slideDown('show');
		jQuery('#open-review-box').hide();
	
	});
	jQuery('#close-review-box').on('click', function(event) {  
		jQuery('#post-review-box').slideUp('hide');
		jQuery('#open-review-box').show();
	});
});

var footerTemplate = '<div class="file-thumbnail-footer">\n' +
'   <div style="margin:5px 0">\n' +
'       <input class="kv-input kv-new form-control input-sm {TAG_CSS_NEW}" value="{caption}" placeholder="Enter caption...">\n' +
'       <input class="kv-input kv-init form-control input-sm {TAG_CSS_INIT}" value="{TAG_VALUE}" placeholder="Enter caption...">\n' +
'   </div>\n' +
'   {actions}\n' +
'</div>';

$("#images").fileinput({
previewFileType: "image",
removeClass: "btn btn-danger",
cancelClass: "btn btn-danger",
browseClass: "btn btn-info",
uploadClass: "btn btn-success",
uploadAsync: false,
uploadUrl: "upload.php",
minFileCount: 1,
maxFileCount: 5,
maxFileSize: 3000,
showUpload: true,
showRemove: true,
allowedFileExtensions: ["jpg", "gif", "png"],
layoutTemplates: {footer: footerTemplate},
previewThumbTags: {
	'{TAG_VALUE}': '',        // no value
	'{TAG_CSS_NEW}': '',      // new thumbnail input
	'{TAG_CSS_INIT}': 'hide'  // hide the initial input
}
});
