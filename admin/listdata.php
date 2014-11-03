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
						data-editing="false" 
						class="<?php echo $key % 2 == 0 ? 'even' : 'uneven'; ?>">
						<td class="app-id"><?php echo $appointment['id']; ?></td>
						<td class="app-name editable" data-edit-type="text" data-edit-name="name"><?php echo $appointment['name']; ?></td>
						<td class="app-email editable" data-edit-type="text" data-edit-name="email"><?php echo $appointment['email']; ?></td>
						<td class="app-phone editable" data-edit-type="text" data-edit-name="phone"><?php echo $appointment['phone']; ?></td>
						<td class="app-comment editable" data-edit-type="textarea" data-edit-name="comment"><?php echo $appointment['comment']; ?></td>
						<td class="app-datetime editable" data-edit-type="datetime" data-edit-name="datetime"><?php echo $appointment['datetime']; ?></td>
						<td class="app-active">
							<input type="checkbox" 
								<?php checked( 1, $appointment['active'] ); ?> 
							/>
						</a>
						</td>
						<td><a class="edit" href="#" alt="<?php _e('Edit', 'cleanbook'); ?>"><span id="edit-icon" class="dashicons dashicons-edit"></span></a></td>
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