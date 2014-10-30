<div class="loading"></div>

<div class="row">
  <div class="col-xs-12 col-sm-8 col-md-9">
    <div class="row calendar-header">
      <div class="col-xs-12 col-md-4">
        <h3 class="current-calendar"></h3>
      </div>
      <div class="col-xs-12 col-md-8">
        <div class="btn-group">
          <button class="btn btn-default" data-calendar-nav="prev">&lt;&lt; <?php echo $translated_labels['previous']; ?></button>
          <button class="btn btn-default" data-calendar-nav="next"><?php echo $translated_labels['next']; ?> &gt;&gt;</button>
        </div>
        <div class="btn-group">
          <button class="btn btn-default" data-calendar-view="year"><?php echo $translated_labels['year']; ?></button>
          <button class="btn btn-default active" data-calendar-view="month"><?php echo $translated_labels['month']; ?></button>
          <button class="btn  btn-default" data-calendar-view="week"><?php echo $translated_labels['week']; ?></button>
          <button class="btn btn-default" data-calendar-view="day"><?php echo $translated_labels['day']; ?></button>
        </div>
      </div>
    </div>
    <div class="row">
      <div id="calendar"></div>
    </div>
  </div>
  <div class="col-xs-12 col-sm-4 col-md-3">
    <h3><?php echo $translated_labels['form-title']; ?></h3>
    <div id="cb-displaymessage" class="alert"></div>

    <form role="form">

      <div class="form-group">
        <label for="cb-name">
          <?php echo $translated_labels['name']; ?> :
        </label>
        <input type="text" class="form-control" id="cb-name" 
        placeholder="<?php echo $translated_labels['name-placeholder']; ?>">
      </div>

      <div class="form-group">
        <label for="cb-email">
          <?php echo $translated_labels['email']; ?> :
        </label>
        <input type="email" class="form-control" id="cb-email" 
        placeholder="<?php echo $translated_labels['email-placeholder']; ?>">
      </div>

      <div class="form-group">
        <label for="cb-phone">
          <?php echo $translated_labels['phone']; ?> :
        </label>
        <input type="text" class="form-control" id="cb-phone" 
        placeholder="<?php echo $translated_labels['phone-placeholder']; ?>">
      </div>

      <div class="form-group">
        <label for="cb-datetime">
          <?php echo $translated_labels['datetime']; ?> :
        </label>
        <input type="text" class="form-control" id="cb-datetime">
      </div>

      <div class="form-group">
        <label for="cb-comment">
          <?php echo $translated_labels['comment']; ?> :
        </label>
        <textarea class="form-control" rows="3" id="cb-comment"
        placeholder="<?php echo $translated_labels['comment-placeholder']; ?>"></textarea>
      </div>
      <button id="btn_appointment" type="submit" class="btn btn-default"><?php echo $translated_labels['submit']; ?></button>
    </form>
  </div>
</div>

