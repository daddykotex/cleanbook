<div class="wrap">
<h2><?php echo $translated_labels['settings-title']; ?></h2>

<form method="post" action="options.php">
    <?php settings_fields( 'cb-settings-group' ); ?>

    <?php do_settings_sections( 'cleanbook_general_page' ); ?>
    
    <?php submit_button(); ?>

</form>
</div>