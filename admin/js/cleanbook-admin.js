jQuery(document).ready(function($) {

	jQuery('.app-active > input:checkbox').click(function(e) {

		var id = jQuery(this).parent().parent().attr('data-id');
		var wasChecked = jQuery(this).is(':checked');

		jQuery('.loading').show();	
		jQuery.ajax({	
			url: cleanbook_admin_ajax.ajax_url,
			type:'POST',
			dataType:"json",
			data: {
				'action': "toggle_active_status",
				'id': id,
				'active': wasChecked
			},

			success: function(response){
				if(!response.success){
					jQuery(this).attr('checked', wasChecked);
				}
			},
			error: function(){
				jQuery(this).attr('checked', wasChecked);
			},
			complete: function() {
				jQuery('.loading').hide(); 
			}

		});
	});

	jQuery("tr > td > a.edit").click(function(e) {
		
		var row = jQuery(this).parent().parent();
		var id = row.attr("data-id");

		tb_show(cleanbook_admin_ajax.modal_title_edit, cleanbook_admin_ajax.ajax_url + '?action=show_form&id=' + id);
		return true;
	});
});

function save(displayMessageHandler, data){

	data.push({name: 'action', value: "update_appointment"});

	jQuery('.loading').show();
	displayMessageHandler.empty();
	displayMessageHandler.hide();

	jQuery.ajax({	
		url: cleanbook_admin_ajax.ajax_url,
		type:'POST',
		dataType:"json",
		data: data,

		success: function(response){
			if(response.success){
				updateRow(response.result);
				tb_remove();
			}else{
				response.messages.forEach(function(message, index) {
					var messageToPrint = jQuery("<p></p>").html(message.message);
					displayMessageHandler.append(messageToPrint);
				});
				displayMessageHandler.show();
			}
		},
		error: function(){
		},
		complete: function() {
			jQuery('.loading').hide(); 
		}

	});
}
function updateRow(updatedAppointment){
	var row = jQuery("#appointment-" + updatedAppointment.id);

	for(var property in updatedAppointment){
		if(property != "active"){
      		jQuery(".app-" + property, row).html(updatedAppointment[property]);
  		} else {
  			if(updatedAppointment[property] == 1){
  				jQuery(".app-" + property + " > input:checkbox", row).attr("checked", "true");
  			} else {
  				jQuery(".app-" + property + " > input:checkbox", row).removeAttr("checked");
  			}
  		}
   }
}