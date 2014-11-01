<?php
$admin_url = admin_url( 'admin-ajax.php' );

global $wpdb;
$appointments = $wpdb->prefix . CLEANBOOK_TABLE_APPOINTMENTS;
$results = $wpdb->get_results("SELECT * FROM $appointments" , ARRAY_A); 
$hasResults = !empty($results);
?>

<div class="wrap">
	<div class="loading">
		<div class="loader"></div>
	</div>

	<h2><?php _e('Manage appointments', 'cleanbook'); ?></h2>

	<div id="appointments">
		<?php if ($hasResults){ ?>
		<table rules="groups">
			<thead  style="border-collapse: collapse;" >
				<tr>
					<th><?php _e('ID', 'cleanbook'); ?></th>
					<th><?php _e( 'Fullname', 'cleanbook' ); ?></th>
					<th><?php _e( 'Email', 'cleanbook' ); ?></th>
					<th><?php _e( 'Phone', 'cleanbook' ); ?></th>
					<th><?php _e( 'Comment', 'cleanbook' ); ?></th>
					<th><?php _e( 'Date and time', 'cleanbook' ); ?></th>
					<th><?php _e( 'Activated', 'cleanbook' ); ?></th>
					<th><?php _e( 'Actions', 'cleanbook' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach($results AS $key=>$appointment){ 
					?>
					<tr id="appointment-<?php echo $appointment['id']; ?>" 
						data-id="<?php echo $appointment['id']; ?>"
						class="<?php echo $key % 2 == 0 ? 'even' : 'uneven'; ?>">
						<td class="app-id"><?php echo $appointment['id']; ?></td>
						<td class="app-name editable" data-edit-type="text"><?php echo $appointment['name']; ?></td>
						<td class="app-email editable" data-edit-type="text"><?php echo $appointment['email']; ?></td>
						<td class="app-phone editable" data-edit-type="text"><?php echo $appointment['phone']; ?></td>
						<td class="app-comment editable" data-edit-type="textarea"><?php echo $appointment['comment']; ?></td>
						<td class="app-datetime editable" data-edit-type="datetime"><?php echo $appointment['datetime']; ?></td>
						<?php
						$active_label = $appointment['active'] ? 
						__( 'Activate', 'cleanbook' ) : 
						__( 'Deactivate', 'cleanbook' );
						?>
						<td class="app-active">
							<input type="checkbox" 
							<?php if($appointment['active']){ echo 'checked' ;} ?> 
							/>
						</a>
						</td>
						<td><a class="edit" data-editing="false" href="#" alt="<?php _e('Edit', 'cleanbook'); ?>">edit</a></td>
					</tr>
				<?php
				}
				?> 
			</tbody>
		</table>
		<?php 
		} else {
			echo '<p>' . __('No appointments were found.', 'cleanbook') .'</p>';
		}
		?>
	</div><!-- #appoitnments -->
</div><!-- wrap -->
<script type="text/javascript">
jQuery(document).ready(function($) { 

	jQuery('.app-active > input:checkbox').click(function(e) {

		var id = jQuery(this).parent().parent().attr('data-id');
		var wasChecked = jQuery(this).is(':checked');

		jQuery('.loading').show();	
		jQuery.ajax({	
			url: '<?php echo $admin_url; ?>',
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
		var saving = jQuery(this).attr("data-editing") == "true";
		alert("saving : " + saving);

		if(saving){
			toggleEditFields(row, false);
			save(row);
		}else {
			toggleEditFields(row, true);
			jQuery(this).attr("data-editing", "true");
		}
	});
});

function toggleEditFields(row, on){
	jQuery("td.editable", row).each(function(index, element){
		var editType = jQuery(this).attr("data-edit-type");

		if(on){
			var editElement;
			var oldValue = jQuery(this).html();

			switch (editType) {
			    case "datetime":
			    	editElement = "<input type='text' class='datetime' value='"+ oldValue +"' />";
			        break;
			    case "textarea":
			    	editElement = "<textarea>"+ oldValue +"</textarea>";
			    	break;
			    default:
			    	editElement = "<input type='text' value='"+ oldValue +"' />";
			        break;
			}
			jQuery(this).html(editElement);
		} else {
			var firstChild = jQuery(this).children()[0];
			var oldValue;
			switch (editType) {
			    case "textarea":
			    	oldValue = jQuery(firstChild).html();
			    	break;
			    default:
			    	oldValue = jQuery(firstChild).attr("value");
			        break;
			}
			jQuery(this).html(oldValue);
		}
	});

}

function save(row){
	var data = jQuery("input, textarea", row).serialize();
	alert(data);
	return;

	jQuery('.loading').show();	
	jQuery.ajax({	
		url: '<?php echo $admin_url; ?>',
		type:'POST',
		dataType:"json",
		data: {
			'action': "update_appointment",
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
}
</script>