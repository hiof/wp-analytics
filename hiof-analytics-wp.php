<?php
  /**
  * Plugin Name: analytics, Østfold University College
  * Plugin URI: https://github.com/hiof/analytics-wp
  * Description: This plugin adds configuration options so the user input their google analaytics code.
  * Version: 1.0.1
  * Author: Kenneth Dahlstrøm <kenneth.dahlstrom@hiof.no>
  * Author URI: http://www.hiof.no/?ID=30056&displayitem=8148&module=admin
  * License: GPL3
  */


  add_action( 'admin_menu', 'hiof_analytics_add_admin_menu' );
  add_action( 'admin_init', 'hiof_analytics_settings_init' );


  function hiof_analytics_add_admin_menu(  ) {

    add_options_page( 'Hiof analytics', 'Hiof analytics', 'manage_options', 'hiof_analytics', 'hiof_analytics_options_page' );

  }


  function hiof_analytics_settings_exist(  ) {

    if( false == get_option( 'hiof_analytics_settings' ) ) {

      add_option( 'hiof_analytics_settings' );

    }

  }


  function hiof_analytics_settings_init(  ) {

    register_setting( 'pluginPage', 'hiof_analytics_settings' );

    add_settings_section(
      'hiof_analytics_pluginPage_section',
      __( 'Google Analytics', 'hiof_analytics' ),
      'hiof_analytics_settings_section_callback',
      'pluginPage'
    );


    add_settings_field(
      'hiof_analytics_text_field_1',
      __( 'Analaytics kode', 'hiof_analytics' ),
      'hiof_analytics_text_field_1_render',
      'pluginPage',
      'hiof_analytics_pluginPage_section'
    );



  }





  function hiof_analytics_text_field_1_render(  ) {
    $options = get_option( 'hiof_analytics_settings' );
    ?>
    <input type='text' name='hiof_analytics_settings[hiof_analytics_text_field_1]' placeholder="UA-XXXXX-X" value='<?php echo $options['hiof_analytics_text_field_1']; ?>'>
    <?php
  }


  function hiof_analytics_text_field_2_render(  ) {
    $options = get_option( 'hiof_analytics_settings' );
    ?>
    <input type='text' name='hiof_analytics_settings[hiof_analytics_text_field_2]' placeholder="5%" value='<?php echo $options['hiof_analytics_text_field_2']; ?>'>
    <?php
  }


  function hiof_analytics_settings_section_callback(  ) {
    echo __( 'Add your Google analytics tracking code.', 'hiof_analytics' );
  }


  function hiof_analytics_options_page(  ) {
    ?>
    <form action='options.php' method='post'>
      <h2>Hiof analytics</h2>
      <?php
      settings_fields( 'pluginPage' );
      do_settings_sections( 'pluginPage' );
      submit_button();
      ?>
    </form>
    <?php
  }


  // Frontend output
  function insert_javascript_hiof_analytics() {

    // Var setup
    $options = get_option( 'hiof_analytics_settings' );

    print "
      <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', '" . $options['hiof_analytics_text_field_1'] . "', 'auto');
        ga('send', 'pageview');

      </script>";

  }


  add_action('wp_footer', 'insert_javascript_hiof_analytics', 100);

?>
