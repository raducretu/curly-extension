(function($) {
  "use strict";
  
  jQuery(document).ready(function($){
  	"use strict";
  	
	  $('a[data-sidebar-id]').off('click').on('click', remove_sidebar);
  	
  });
  
  $('#add-sidebar').submit(function (e) {
  	
  	e.preventDefault();
  	
  	jQuery.post(
  	    ajaxurl, 
  	    {
  	        'action': 'update_sidebars',
  	        'name'	: $('#add-sidebar-field').val(),
  	        'id'	: '',
  	        'method': 'update'
  	    }, 
  	    function(response){
  	    	
  	        if ( response == 'duplicate' ) {
  	        	
  	        	$('#messages').append('<p class="error">' + js_data[3] + '</p>');

  	        } else if ( response == 'empty' ) {
  	        
  	        	$('#messages').append('<p class="error">' + js_data[2] + '</p>');
  	        	
  	        } else {
  	        	
  	        	var response_obj = jQuery.parseJSON( response );	
  	        	$('#no-sidebar').remove();
  	        	$('#sidebar-list').append('<li>' + response_obj[1] + '<code>[dynamic-sidebar id="' + response_obj[0] + '"]</code> <a href="#" data-sidebar-id="' + response_obj[0] + '">' + js_data[0] + '</a></li>');
  	        	$('a[data-sidebar-id]').off('click').on('click', remove_sidebar);
  	        	$('#add-sidebar-field').val(null);
  	        	
  	        	$('#messages').append('<p class="success">' + js_data[4] + '</p>');
  	        	
  	        }
  	        
  	        setTimeout(function(){ $('#messages > p').fadeOut(); }, 4000);
  	    }
  	);
  });
  
  
  function remove_sidebar() {
  
  	var sidebar = $(this);
  	
	if ( confirm( js_data[1] ) == true ) {
	
		jQuery.post(
		    ajaxurl, 
		    {
		        'action': 'update_sidebars',
		        'name'  : '',
		        'id'	: sidebar.data('sidebar-id'),
		        'method': 'delete'
		    }, 
		    function(response){
		    
		        if ( response == 'success' ) {
		        
		        	if ( sidebar.parents('#sidebar-list').children().length == 1 ) {
		        		$('#sidebar-list').append('<li id="no-sidebar">' + js_data[5] + '</li>');
		        	}
		        	
		        	sidebar.parent().remove();
		        	
		        }
		    }
		);
	}
	
	return false;
	
  }
  
})(jQuery);