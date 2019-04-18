<?php

/**
 * A class which initiate the plugin
 */

 class BPWF_Helper_Init 
 {
     public function __construct()
     {
        // Init controller
        new BPWF_Controller_Controller();

        // Add all important scripts
        add_action('bp_enqueue_scripts', array($this, 'add_scripts'));
     }

     static function init()
     {
        // Database Version

        global $wpdb;

        global $bwf_db_version;

        $bwf_db_version = '1.0';

	    $table_name = $wpdb->prefix . 'bpwhofav';
	
	    $charset_collate = $wpdb->get_charset_collate();

	    $sql = "CREATE TABLE $table_name 
            (
		        id mediumint(9) NOT NULL AUTO_INCREMENT,
                activity_id mediumint(9) NOT NULL,
                fav_user_id mediumint(9) NOT NULL,
                time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		        PRIMARY KEY  (id)
	        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    
	    dbDelta( $sql );

        add_option( 'bwf_db_version', $bwf_db_version );
            
    }

    public function add_scripts()
    {
        // Load css
        wp_enqueue_style('bpwf',  plugins_url().'/bp-who-favorited/lib/view/css/bpwf.css');
        
        // Localize the script with new data
        wp_register_script('bpwf', plugins_url().'/bp-who-favorited/lib/view/js/bpwf.js',array('jquery'));
        wp_localize_script( 'bpwf', 'bpwfAjax', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' )
            ));

        // Enqueued script with localized data.
        wp_enqueue_script( 'bpwf',plugins_url().'/bp-who-favorited/lib/view/js/bpwf.js',array('jquery') );
    }
 
}