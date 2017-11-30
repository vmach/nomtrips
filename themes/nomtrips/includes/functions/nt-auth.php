<?php
/**-------------------------------
 * action/filters for oauth 2 login
**_____________________________/

/**
 * Set access_token as cookie
**/
function nt_set_oauth_user_token_cookie() {
  $user_id = get_current_user_id();
  $auth_token = get_user_meta( $user_id, 'wordpress_access_token', true);
  if(!empty($auth_token) && $user_id > 0) {
    setcookie( 'wordpress_access_token', $auth_token, time() + 3600, COOKIEPATH, COOKIE_DOMAIN, 0 );
  } else {
    unset( $_COOKIE['wordpress_access_token'] );
  }
}
add_action( 'init', 'nt_set_oauth_user_token_cookie' );

/**
 * Get access_token from db 
**/
function nt_get_oauth_user_token_cookie($user_id) {
  $user_id = isset($user_id) ? $user_id : get_current_user_id();
  $auth_token = get_user_meta( $user_id, 'wordpress_access_token', true);
  if(!empty($auth_token) && $user_id > 0) {
    return $auth_token;
  } else {
    return null;
  }
}

/**
 * Delete access_token cookie when logging out
**/
function nt_delete_oauth_user_token_cookie() {
  $user_id = get_current_user_id();
  $auth_token = get_user_meta( $user_id, 'wordpress_access_token', true);
  //remove the cookie
  //nt_debug(isset($_COOKIE['wordpress_access_token'] ));
  if( isset($_COOKIE['wordpress_access_token'] ) ) {    
    setcookie( 'wordpress_access_token', $auth_token, time() - 1, COOKIEPATH, COOKIE_DOMAIN, 0 );
  }
  //remove the token from db
  if( !empty($auth_token) ) {
    //nt_debug("dd");
    delete_user_meta( $user_id, 'wordpress_access_token' );
  }
}
add_action( 'wp_logout', 'nt_delete_oauth_user_token_cookie' );

/**
 * redirect to oauth login page if use default wp-login.php
**/
add_filter( 'login_redirect', 'nt_login_redirect', 10, 3 );
function nt_login_redirect( $redirect_to, $request, $user ) {
    return site_url() . '/login';
}

/**
 * show user access token in admin
**/
if (current_user_can('manage_options')) {
  add_action('admin_notices', 'display_user_token');
}
function display_user_token() {
  $user_id = get_current_user_id();
  $auth_token = get_user_meta( $user_id, 'wordpress_access_token', true);
  /* uncomment this to show */
  nt_debug($auth_token);
}