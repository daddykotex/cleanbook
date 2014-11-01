<?php
$admin_url = admin_url( 'admin-ajax.php' );
$action = "toggle_active_status";

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
					<th><?php _e( 'Actions', 'cleanbook' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach($results AS $key=>$appointment){ 
					?>
					<tr id="appointment-<?php echo $appointment['id']; ?>" 
						class="<?php echo $key % 2 == 0 ? 'even' : 'uneven'; ?>">
						<td class="app-id"><?php echo $appointment['id']; ?></td>
						<td class="app-name editable"><?php echo $appointment['name']; ?></td>
						<td class="app-email editable"><?php echo $appointment['email']; ?></td>
						<td class="app-phone editable"><?php echo $appointment['phone']; ?></td>
						<td class="app-comment editable"><?php echo $appointment['comment']; ?></td>
						<td class="app-datetime editable"><?php echo $appointment['datetime']; ?></td>
						<?php
						$active_label = $appointment['active'] ? 
						__( 'Activate', 'cleanbook' ) : 
						__( 'Deactivate', 'cleanbook' );
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