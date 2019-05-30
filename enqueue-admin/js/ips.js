(function($) {
  	"use strict";
  	
  	// Document Ready
  	$(document).ready( function() {
	  	
	  	// Clear Buttons
	  	$('.image-clear-button').click( function (e) {
	  		$(this).siblings('input[type=text]').val(null);
	  		$(this).siblings('input[type=hidden]').val(null).trigger('change');
	  		$(this).siblings('.image-preview').remove();
	  		e.preventDefault();
	  	});
	  	
	  	// Clear Buttons
	  	$('.video-clear-button').click( function (e) {
	  		$(this).siblings('input[type=text]').val(null);
	  		e.preventDefault();
	  	});
	  	
	  	// Tabs
	  	var tabber = new HashTabber();
	  	tabber.run();
  		
  		// Color Picker	
  		$('.color-picker').wpColorPicker();
  		
  		// Panels Height
  		var list_height = 100;
  		$('#individual-page-settings-wrapper > ul > li[role*=tab]').each(function () {
  			list_height += $(this).outerHeight();
  		});
  		
  		$('#individual-page-settings-wrapper div.ui-tabs-panel').each(function () {
  			var existing_style = $(this).attr('style');
  			var new_style = ( existing_style ) ? (existing_style + ' min-height: ' + list_height + 'px;') : 'min-height: ' + list_height + 'px;';
  			$(this).attr('style', new_style);
  		});
  		
  		// Image Field
  		call_image_field();
  		call_video_field();
  		
  		function call_image_field() {
  			// Function Upload Media
  			$('.image-upload-button').click(function (e) {
  				var el = $(this).parent();
  				var button = $(this);
  				e.preventDefault();
  				var uploader = wp.media({
  					title : button.data('upload-title'),
  					button : {
  						text : button.data('upload-button')
  					},
  					multiple : false
  				})
  				.on('select', function () {
  					var selection = uploader.state().get('selection');
  					var attachment = selection.first().toJSON();
  					$('input[type=text]', el).val(attachment.url);
  					$('input[type=hidden]', el).val(attachment.id).trigger('change');
  					if (!el.hasClass('upload_file')) {
  						if ($('img', el).length > 0) {
  							$('.image-preview', el).attr('src', attachment.url);
  						} else {
  							$('<img src="'+ attachment.url +'" class="image-preview">').insertBefore($(':last-child', el));
  							$('.image-clear-button', el).attr('style', 'display:inline-block');
  						}
  					}
  				})
  				.open();
  			});
  		}
  		
  		function call_video_field() {
  			// Function Upload Media
  			$('.video-upload-button').click(function (e) {
  				var el = $(this).parent();
  				var button = $(this);
  				e.preventDefault();
  				var uploader = wp.media({
  					title : button.data('upload-title'),
  					button : {
  						text : button.data('upload-button')
  					},
  					multiple : false
  				})
  				.on('select', function () {
  					var selection = uploader.state().get('selection');
  					var attachment = selection.first().toJSON();
  					$('input[type=text]', el).val(attachment.url);
  					if (!el.hasClass('upload_file')) {
  						$('.video-clear-button', el).attr('style', 'display:inline-block');
  					}
  				})
  				.open();
  			});
  		}
  		
  	});
  	
})(jQuery); 
