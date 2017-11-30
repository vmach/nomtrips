<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/* load settings */
require_once ( get_stylesheet_directory() . '/includes/global-variables.php' );

/* load classes */
require_once ( NT_INCLUDE_PATH . 'classes/class-custom-post-type.php' );
require_once ( NT_INCLUDE_PATH . 'classes/class-custom-metadata-form.php' );
require_once ( NT_INCLUDE_PATH . 'classes/class-custom-taxonomy.php' );
require_once ( NT_INCLUDE_PATH . 'classes/class-banner.php' );
require_once ( NT_INCLUDE_PATH . 'classes/class-city.php' );
require_once ( NT_INCLUDE_PATH . 'classes/class-restaurant.php' );
require_once ( NT_INCLUDE_PATH . 'classes/class-carousel.php' );
require_once ( NT_INCLUDE_PATH . 'classes/class-nomtrip-post.php' );
require_once ( NT_INCLUDE_PATH . 'classes/class-itinerary.php' );
require_once ( NT_INCLUDE_PATH . 'classes/class-nomlist.php' );

/* custom functions */
require_once ( NT_INCLUDE_PATH . '/functions/nt-functions.php' );
require_once ( NT_INCLUDE_PATH . '/functions/nt-actions.php' );
require_once ( NT_INCLUDE_PATH . '/functions/nt-auth.php' );
require_once ( NT_INCLUDE_PATH . '/functions/nt-register-endpoints.php' );

/* menus */
require_once ( NT_INCLUDE_PATH . 'functions/nt-menus.php' );

/* load 3rd party plugins */
require_once ( NT_PLUGIN_PATH . 'Tax-meta-class/Tax-meta-class.php' );

/* load images sizes and helpers */
require_once ( NT_INCLUDE_PATH . 'functions/nt-image-sizes.php' );

/* load custom plugins and fields */
require_once ( NT_INCLUDE_PATH . '/fields/nt-fields-user.php' );
require_once ( NT_INCLUDE_PATH . '/fields/nt-fields-contact.php' );
require_once ( NT_INCLUDE_PATH . '/fields/nt-fields-social.php' );
require_once ( NT_PLUGIN_PATH_REL . '/nt-cpt-restaurant/nt-cpt-restaurant.php' );
require_once ( NT_PLUGIN_PATH_REL . '/nt-cpt-nomlist/nt-cpt-nomlist.php' );
require_once ( NT_PLUGIN_PATH_REL . '/nt-cpt-itinerary/nt-cpt-itinerary.php' );
require_once ( NT_PLUGIN_PATH_REL . '/nt-taxonomies/nt-taxonomies.php' );

/*stylesheets & scripts*/
require_once ( NT_INCLUDE_PATH . '/functions/nt-stylesheets.php' );
require_once ( NT_INCLUDE_PATH . '/functions/nt-scripts.php' );