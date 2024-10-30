<div class="wrap">
    <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
    <?php settings_errors(); ?>
    <form action="options.php" method="post">
        <?php
            settings_fields( 'business-hub-toolbox' );
            do_settings_sections( 'business-hub-toolbox' );
            submit_button();
        ?>
    </form>
</div>