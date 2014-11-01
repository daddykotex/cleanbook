// JavaScript Document
jQuery(document).ready(function($) { 

	jQuery('#cb-datetime').datetimepicker({ 
   		minDate:'0',
   		format: "Y-m-d H:i:s",
 	});	
	var list_appointments = cleanbook_ajax.ajax_url + "?action=" + cleanbook_ajax.action_listing;

	var calendar = jQuery('#calendar').calendar({
		language: cleanbook_ajax.language,
		tmpl_path: cleanbook_ajax.tmpl_path,
		first_day: 2,
		view: 'month', 
		events_source: list_appointments,

		onAfterViewLoad: function(view) {
			jQuery(".loading").hide();

			jQuery('h3.current-calendar').text(this.getTitle());
			jQuery('.btn-group button').removeClass('active');
			jQuery('button[data-calendar-view="' + view + '"]').addClass('active');
		}
		
	});

	jQuery('.btn-group button[data-calendar-nav]').each(function() {
		var handle = jQuery(this);
		handle.click(function() {
			jQuery(".loading").show();
			calendar.navigate(handle.data('calendar-nav'));
		}); 
	});

	jQuery('.btn-group button[data-calendar-view]').each(function() {
		var handle = jQuery(this);
		handle.click(function() {
		jQuery(".loading").show();
			calendar.view(handle.data('calendar-view'));
		});
	});

	jQuery('#btn_appointment').click(function(e) {

		var message = jQuery('#cb-displaymessage');
		message.hide();
		message.removeClass("alert-success alert-danger");

		var appointment_name = jQuery('#cb-name');
		var appointment_email = jQuery('#cb-email');
		var appointment_phone = jQuery('#cb-phone');		
		var datetime = jQuery('#cb-datetime');	
		var appointement_comment = jQuery('#cb-comment');

		jQuery(".loading").show();

		jQuery.ajax({	
			url: cleanbook_ajax.ajax_url,
			type:'POST',
			dataType:"json",
			data: {
				action: cleanbook_ajax.action_booking,
				name:appointment_name.val(),
				email:appointment_email.val(),
				phone:appointment_phone.val(),
				datetime:datetime.val(),
				comment:appointement_comment.val(),
			},
			success: function(response){
				if(response.success){
					appointment_name.val('');
					appointment_email.val('');
					appointment_phone.val('');
					datetime.val('');
					appointement_comment.val('');

					message.toggleClass("alert-success");
				} else {
					message.toggleClass("alert-danger");
				}
				var messageToPrint = '';
				response.messages.forEach(function(message, index) {
					messageToPrint += message.message;
					if(index != response.messages.length - 1){
						messageToPrint += "<br />";
					}
				});
				message.html(messageToPrint);
				message.show();

			},
			complete:function(){
				jQuery(".loading").hide();
			}

		});
		return false;
	});	
});