<?php
/**
  * Actions and filters
**/


/* add_filter( 'wp_headers', 'my_add_origins' );
function my_add_origins( $origins ) {
	
    // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
    // you want to allow, and if so:
    header("Access-Control-Allow-Origin: maps.googleapis.com");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
    
 
  nt_debug($_SERVER) ;

  // Access-Control headers are received during OPTIONS requests
  if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        // may also be using PUT, PATCH, HEAD etc
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
  }
} */


/**
 * apply tags to attachments
**/
function nt_add_tags_to_attachments() {
    register_taxonomy_for_object_type( 'post_tag', 'attachment' );
}
add_action( 'init' , 'nt_add_tags_to_attachments' );

/**
 * rewrite url filter restaurants, put city name in front
*/
function restaurant_permalink($permalink, $post_id, $leavename) {
  if (strpos($permalink, '%city%') === FALSE) return $permalink;
    // Get post
    $post = get_post($post_id);
    if (!$post) return $permalink;

    // Get taxonomy terms
    $terms = wp_get_object_terms($post->ID, 'city');
    if (!is_wp_error($terms) && !empty($terms) && is_object($terms[0]))
      $taxonomy_slug = $terms[0]->slug;
    else $taxonomy_slug = 'no-city';

  return str_replace('%city%', $taxonomy_slug, $permalink);
}
add_filter('post_link', 'restaurant_permalink', 1, 3);
add_filter('post_type_link', 'restaurant_permalink', 1, 3);
