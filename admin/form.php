<div id="displaymessage"></div>
<form id="edit_appointment" role="form">
  <input name="id" type="hidden" value="<?php if($currentAppointment){echo $currentAppointment['id'];} ?>" />
  <table>
    <tr>
      <td>
        <label for="cb-name">
          <?php _e( 'Fullname', 'cleanbook' ); ?> :
        </label>
      </td>
      <td>
        <input name="name" type="text" id="cb-name" 
        value="<?php if($currentAppointment){echo $currentAppointment['name'];} ?>">
      </td>
    </tr>

    <tr>
      <td>
        <label for="cb-email">
          <?php _e( 'Email', 'cleanbook' ); ?> :
        </label>
      </td>
      <td>
        <input name="email" type="email" id="cb-email" 
        value="<?php if($currentAppointment){echo $currentAppointment['email'];} ?>">
      </td>
    </tr>

    <tr>

      <td>
        <label for="cb-phone">
          <?php _e( 'Phone', 'cleanbook' ); ?> :
        </label>
      </td>
      <td>
        <input name="phone" type="text" id="cb-phone" 
        value="<?php if($currentAppointment){echo $currentAppointment['phone'];} ?>">
      </td>
    </tr>

    <tr>
      <td>
        <label for="cb-datetime">
          <?php _e( 'Date and time', 'cleanbook' ); ?> :
        </label>
      </td>
      <td>
        <input name="datetime" type="text" id="cb-datetime"
        value="<?php if($currentAppointment){echo $currentAppointment['datetime'];} ?>">
      </td>
    </tr>

    <tr>
      <td>
        <label for="cb-comment">
          <?php _e( 'Comment', 'cleanbook' ); ?> :
        </label>
      </td>
      <td>
        <textarea name="comment" rows="3" id="cb-comment"><?php if($currentAppointment){echo $currentAppointment['comment'];} ?></textarea>
      </td>
    </tr>
    <tr>
      <td>
        <?php _e( 'Activate', 'cleanbook' ); ?> :
      </td>
      <td>
        <input name="active" type="checkbox" value="1"
          <?php checked( 1, $currentAppointment['active'] ); ?> 
              />
      </td>
    </tr>
  </table>

  <br />

  <button id="btn_appointment_save" type="submit">
    <?php _e( 'Submit', 'cleanbook' ); ?>
  </button>

  <button id="btn_appointment_cancel" type="submit">
    <?php _e( 'Cancel', 'cleanbook' ); ?>
  </button>
</form>
<script type="text/javascript">
jQuery(document).ready(function($) {

  jQuery('#btn_appointment_save').click(function(e) {
    var data = jQuery("#edit_appointment").serializeArray();
    save(jQuery("#displaymessage"), data);
    return false;
  }); 

  jQuery('#btn_appointment_cancel').click(function(e) {
    tb_remove();
    return false;
  }); 
  
});
</script>