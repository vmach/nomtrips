<?php

/**
* not logged in - public site
**/

if (!is_admin())
  add_action( 'wp_enqueue_scripts', 'nt_add_js' );

function nt_add_js() {
  $template_directory_uri = get_template_directory_uri();

  wp_enqueue_script( 'jquery');
  wp_enqueue_script( 'jquery-ui');

  //foundation framework js
  wp_enqueue_script( 'foundation', NT_JS_PATH . 'vendor/foundation/foundation.js', array('jquery'), '', true );
  wp_enqueue_script( 'foundation-app', NT_JS_PATH . 'vendor/foundation/app.js', array('jquery'), '', true );

  //https://github.com/scottjehl/picturefill
  wp_enqueue_script( 'picturefill', NT_JS_PATH . 'vendor/picturefill/picturefill.js', array('jquery'), '', true );

  //responsive bg images (https://github.com/M6Web/picturefill-background)
  wp_enqueue_script( 'picturefill-background', NT_JS_PATH . 'vendor/picturefill-background/picturefill-background.js', array('jquery'), '', true );

  //slick carousel
  wp_enqueue_script( 'slick', NT_JS_PATH . 'vendor/slick/slick.js', array('jquery'), '', true );
  wp_enqueue_script( 'slick-init', NT_JS_PATH . 'vendor/slick/slick-init.js', array('jquery'), '', true );

  //Misc 3rd party
  wp_enqueue_script( 'js-sha1', NT_JS_PATH . 'vendor/jsSha1.js', array('jquery'), '', true );

  //ajax
  wp_enqueue_script( 'nt-ajax-lists', NT_JS_PATH . 'nomtrips/ajax/nt_ajax_lists.js', array('jquery'), '', true );
  // wp_enqueue_script( 'nt-login-request', NT_JS_PATH . 'nomtrips/login/request.js', array('jquery'), '', true );

  //nomtrip scripts
  wp_enqueue_script( 'nt-script', NT_JS_PATH . 'nomtrips/nt_script.js', array('jquery'), '', true );

//if a city page load angular 2 files
if(is_tax( 'city' )) {
  wp_enqueue_script( 'map-app-bundle-inline', MAP_APP . 'dist/inline.bundle.js', array(), '', true );
  wp_enqueue_script( 'map-app-bundle-polyfills', MAP_APP . 'dist/polyfills.bundle.js', array(), '', true );
  wp_enqueue_script( 'map-app-bundle-styles', MAP_APP . 'dist/styles.bundle.js', array(), '', true );
  wp_enqueue_script( 'map-app-bundle-vendor', MAP_APP . 'dist/vendor.bundle.js', array(), '', true );
  wp_enqueue_script( 'map-app-bundle-main', MAP_APP . 'dist/main.bundle.js', array(), '', true );
} 

//wp-api nonce
  wp_localize_script( 'nt-ajax-lists', 'wpApiSettings',
  array(
    'root' => esc_url_raw( rest_url() ),
    'nonce' => wp_create_nonce( 'wp_rest' ),
    'current_user_id' => get_current_user_id(),
    'success' => __( 'Positive!', 'nomtrips' ),
    'failure' => __( 'Negative', 'nomtrips' )
    )
  );
}

/**
 * localize script for access token  
**/
function nt_localize_access_token_script() {
  $user_id = get_current_user_id();
  $auth_token = get_user_meta( $user_id, 'wordpress_access_token', true);  
  $city = get_term_by('slug', get_query_var( 'city', '' ), 'city');
  
  if(!empty($auth_token) && $user_id > 0) {
    wp_localize_script( 'map-app-bundle-inline', 'localized_access_token', array(
      'access_token' => $auth_token,
      'user_id' => $user_id,
      'city' => $city
    ));
  } else {
    wp_localize_script( 'map-app-bundle-inline', 'localized_access_token', array('access_token' => false) );
  }
}
add_action( 'wp_enqueue_scripts', 'nt_localize_access_token_script' );


/**
* admin section
**/

if (is_admin())
  add_action( 'admin_enqueue_scripts', 'nt_add_js_admin' );

function nt_add_js_admin() {
  wp_enqueue_script( 'nt-admin-scripts', NT_JS_PATH . 'admin/nt-admin-scripts.js', array('jquery'), '', true );
}