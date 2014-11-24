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
      <?php include_once(CLEANBOOK_FILE_PATH . '/form.php'); ?>
  </div>
</div>

