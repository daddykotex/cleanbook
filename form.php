<form role="form">

  <div class="form-group">
    <label for="cb-name">
      <?php _e( 'Fullname', 'cleanbook' ); ?> :
    </label>
    <input type="text" class="form-control" id="cb-name" 
    placeholder="<?php _e( 'First name Last name', 'cleanbook' ); ?>">
  </div>

  <div class="form-group">
    <label for="cb-email">
      <?php _e( 'Email', 'cleanbook' ); ?> :
    </label>
    <input type="email" class="form-control" id="cb-email" 
    placeholder="<?php _e( 'example@email.com', 'cleanbook' ); ?>">
  </div>

  <div class="form-group">
    <label for="cb-phone">
      <?php _e( 'Phone', 'cleanbook' ); ?> :
    </label>
    <input type="text" class="form-control" id="cb-phone" 
    placeholder="<?php echo _e( '(514) 555-5555', 'cleanbook' ); ?>">
  </div>

  <div class="form-group">
    <label for="cb-datetime">
      <?php _e( 'Date and time', 'cleanbook' ); ?> :
    </label>
    <input type="text" class="form-control" id="cb-datetime">
  </div>

  <div class="form-group">
    <label for="cb-comment">
      <?php _e( 'Comment', 'cleanbook' ); ?> :
    </label>
    <textarea class="form-control" rows="3" id="cb-comment"
    placeholder="<?php _e( 'Please add any note regarding the booking...', 'cleanbook' ); ?>"></textarea>
  </div>
  <button id="btn_appointment" type="submit" class="btn btn-default"><?php _e( 'Submit', 'cleanbook' ); ?></button>
</form>