<?php
/**
  * nomlists for user for city
**/
add_action( 'rest_api_init', function () {
  register_rest_route( 'nomtrips/nomlist', '/city/(?P<cityid>\d+)/user/(?P<userid>\d+)/get/access_token=(?P<access_token>[a-zA-Z0-9-]+)', array(
    'methods' => 'GET',
    'callback' => 'nt_nomlist_get',
    'args' => array(
        'cityid' => array(
          'validate_callback' => function($param, $request, $key) {
            return is_numeric( $param );
          }
        ),
        'userid' => array(
          'validate_callback' => function($param, $request, $key) {
            return is_numeric( $param );
          }
        )
      ),
  ) );
} );

function nt_nomlist_get(WP_REST_Request $request) {
  $parameters = $request->get_params();
  $access_token = nt_get_oauth_user_token_cookie($parameters['userid']);  
  if($access_token === $parameters['access_token']) {
    $nomlist = new Nomlist($parameters['cityid'], $parameters['userid']);
    $nomlist->get_nomlist();
    if (!$nomlist->nomlist_id) {
      $nomlist->error = "No Nomlists were found. NomlistID=".$nomlist->nomlist_id;
      return $nomlist;
    } 
    else {
      return $nomlist;
    }
    //return $parameters;
  } else {
    $nomlist->error = new Exception("Invalid Token: You don't have access to this content.");
    return json_decode(json_encode($nomlist->error), true);
  }
}

/**
 * get list of restaurants in a nomlist
 */
add_action( 'rest_api_init', function () {
  register_rest_route( 'nomtrips/nomlist/nomlistid', '/(?P<nomlistid>\d+)/city/(?P<cityid>\d+)/user/(?P<userid>\d+)/get/access_token=(?P<access_token>[a-zA-Z0-9-]+)', array(
    'methods' => 'GET',
    'callback' => 'nt_get_restaurants_in_nomlist',
    'args' => array(
        'nomlistid' => array(
          'validate_callback' => function($param, $request, $key) {
            return is_numeric( $param );
          }
        ),
        'userid' => array(
          'validate_callback' => function($param, $request, $key) {
            return is_numeric( $param );
          }
        )
      ),
  ) );
} );

function nt_get_restaurants_in_nomlist(WP_REST_Request $request) {
  $parameters = $request->get_params();
  $access_token = nt_get_oauth_user_token_cookie($parameters['userid']);  
  if($access_token === $parameters['access_token']) {
    $nomlist = new Nomlist($parameters['cityid'], $parameters['userid']);
    $nomlist->get_nomlist();
    if (!$nomlist->nomlist_id) {
      $nomlist->error = "No Nomlists were found. NomlistID=".$nomlist->nomlist_id;
      return $nomlist;
    } 
    else {
      $nomlist->restaurant_list = $nomlist->get_restaurants_in_nomlist_by_id($nomlist->nomlist_id);
      return $nomlist;
    }
    //return $parameters;
  } else {
    $nomlist->error = new Exception("Invalid Token: You don't have access to this content.");
    return json_decode(json_encode($nomlist->error), true);
  }
}

/**
  * Restaurants list
**/
add_action( 'rest_api_init', function () {
  register_rest_route( 'restaurant-api/restaurant-list', '/city/(?P<cityid>\d+)', array(
    'methods' => 'GET',
    'callback' => 'nt_get_restaurant_in_city',
    'args' => array(
        'cityid' => array(
          'validate_callback' => function($param, $request, $key) {
            return is_numeric( $param );
          }
        )
      ),
  ) );
} );

function nt_get_restaurant_in_city(WP_REST_Request $request) {
  $parameters = $request->get_params();
  $term = get_term_by('id', $parameters['cityid'], 'city');
  $carousel = new Carousel( 'restaurant', 50, 'city', array($term->slug) );
  $carousel->get_posts();
  return $carousel->get_restaurant_objects();  
}

/**
 * Add restaurant to Nomlist
 **/
 add_action( 'rest_api_init', function () {
  register_rest_route( 'nomtrips/nomlist', '/city/(?P<cityid>\d+)/user/(?P<userid>\d+)/restaurant/(?P<restaurantid>\d+)/add/access_token=(?P<access_token>[a-zA-Z0-9-]+)', array(
    'methods' => 'PUT',
    'callback' => 'nt_nomlist_add_restuarant',
    'args' => array(
        'cityid' => array(
          'validate_callback' => function($param, $request, $key) {
            return is_numeric( $param );
          }
        ),
        'userid' => array(
          'validate_callback' => function($param, $request, $key) {
            return is_numeric( $param );
          }
        ),
        'restaurantid' => array(
          'validate_callback' => function($param, $request, $key) {
            return is_numeric( $param );
          }
        )
      ),
  ) );
} );

function nt_nomlist_add_restuarant(WP_REST_Request $request) {
  $parameters = $request->get_params();
  $access_token = nt_get_oauth_user_token_cookie($parameters['userid']);  
  if($access_token === $parameters['access_token']) {
    $nomlist = new Nomlist($parameters['cityid'], $parameters['userid']);
    $nomlist->add_restaurant_to_nomlist($parameters['restaurantid']);
    return $nomlist;
    //return $parameters;
  } 
  else {
    $this->$error = "Invalid Token: You don't have access to this content.";
    return false;
  }
}