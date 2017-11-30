<?php
/*
Plugin Name: Modernizr
Plugin URI: http://www.ramoonus.nl/wordpress/modernizr/
Description: Modernizr is a small JavaScript library that detects the availability of native implementations for next-generation web technologies
Version: 3.3.1
Author: Ramoonus
Author URI: http://www.ramoonus.nl/
*/

function rw_modernizr() {
		wp_deregister_script('modernizr'); // deregister
		wp_enqueue_script('wp_enqueue_scripts', plugins_url('/js/modernizr-custom.js', __FILE__), array('jquery'), '3.3.1', false);
}
add_action('wp_enqueue_scripts', 'rw_modernizr');