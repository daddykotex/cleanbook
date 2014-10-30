<?php
$admin_url = admin_url( 'admin-ajax.php' );
$action = "toggle_active_status";

global $wpdb;
$appointments = $wpdb->prefix . CLEANBOOK_TABLE_APPOINTMENTS;
$results = $wpdb->get_results("SELECT * FROM $appointments" , ARRAY_A); 
?>
<div class="loading">
	<div class="loader"></div>
</div>

<h2><?php echo $translated_labels['listing-title']; ?></h2>

<div id="appointments">
	<table rules="groups">
		<thead  style="border-collapse: collapse;" >
			<tr>
				<th><?php echo $translated_labels['id']; ?></th>
				<th><?php echo $translated_labels['name']; ?></th>
				<th><?php echo $translated_labels['email']; ?></th>
				<th><?php echo $translated_labels['phone']; ?></th>
				<th><?php echo $translated_labels['comment']; ?></th>
				<th><?php echo $translated_labels['datetime']; ?></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach($results AS $key=>$appointment){ 
				?>
				<tr id="appointment-<?php echo $appointment['id']; ?>" 
					class="<?php echo $key % 2 == 0 ? 'even' : 'uneven'; ?>">
					<td class="app-id"><?php echo $appointment['id']; ?></td>
					<td class="app-name"><?php echo $appointment['name']; ?></td>
					<td class="app-email"><?php echo $appointment['email']; ?></td>
					<td class="app-phone"><?php echo $appointment['phone']; ?></td>
					<td class="app-comment"><?php echo $appointment['comment']; ?></td>
					<td class="app-datetime"><?php echo $appointment['datetime']; ?></td>
					<?php
					$active_label = $appointment['active'] ? 
					$translated_labels['deactivate'] : 
					$translated_labels['activate'];
					?>
					<td class="app-active">
						<input type="checkbox" 
						<?php if($appointment['active']){ echo 'checked' ;} ?> 
						data-id="<?php echo $appointment['id']; ?>"
						/>
					</a>
				</td>
			</tr>
			<?php
		}
		?> 
	</tbody>
</table>
</div>

<script type="text/javascript">
jQuery(document).ready(function($) { 

	jQuery('.app-active > input:checkbox').click(function(e) {

		var id = jQuery(this).attr('data-id');
		var wasChecked = jQuery(this).is(':checked');

		jQuery('.loading').show();	
		jQuery.ajax({	
			url: '<?php echo $admin_url; ?>',
			type:'POST',
			dataType:"json",
			data: {
				'action': '<?php echo $action; ?>',
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
});
</script>