<div class="loading"></div>

<div class="row">
  <div class="col-xs-12 col-sm-8 col-md-9">
    <div class="row calendar-header">
      <div class="col-xs-12 col-md-4">
        <h3 class="current-calendar"></h3>
      </div>
      <div class="col-xs-12 col-md-8">
        <div class="btn-group">
          <button class="btn btn-default" data-calendar-nav="prev">&lt;&lt; <?php _e( 'Previous', 'cleanbook' ); ?></button>
          <button class="btn btn-default" data-calendar-nav="next"><?php _e( 'Next', 'cleanbook' ); ?> &gt;&gt;</button>
        </div>
        <div class="btn-group">
          <button class="btn btn-default" data-calendar-view="year"><?php _e( 'Year', 'cleanbook' ); ?></button>
          <button class="btn btn-default active" data-calendar-view="month"><?php _e( 'Month', 'cleanbook' ); ?></button>
          <button class="btn  btn-default" data-calendar-view="week"><?php _e( 'Week', 'cleanbook' ); ?></button>
          <button class="btn btn-default" data-calendar-view="day"><?php _e( 'Day', 'cleanbook' ); ?></button>
        </div>
      </div>
    </div>
    <div class="row">
      <div id="calendar"></div>
    </div>
  </div>
  <div class="col-xs-12 col-sm-4 col-md-3">
    <h3><?php _e( 'Schedule an appointment', 'cleanbook' ); ?></h3>
    <div id="cb-displaymessage" class="alert"></div>

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
  </div>
</div>

