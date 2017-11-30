<?php
/******
 * misc custom helper function definitions
******/

/**
 * theme supports
*/
add_theme_support( 'post-thumbnails' );

//debugging function
function nt_debug( $var ) {
  echo '<blockquote><pre>';
  $pre = print_r( $var, true );
  echo esc_html( $pre );
  echo '</pre></blockquote>';
}

/**
 * Gets cities from city taxonomy and returns an array
*/
function nt_get_cities() {
  $cities_array = get_terms( 'city' );
  $cities = array();
  foreach( $cities_array as $c ) {
    $cities[$c->slug] = $c->name;
  }
  return $cities;
}

/**
 * Return post id
 * @uses WP_Query
 * @uses get_queried_object()
 * @see get_the_ID()
 * @return int
 */
function nt_get_the_post_id() {
  if (in_the_loop()) {
       $post_id = get_the_ID();
  } else {
       global $wp_query;
       $post_id = $wp_query->get_queried_object_id();
         }
  return $post_id;
}

/**
 * return media queries from css (using default foundation mq's)
*/
function nt_media_queries() {
  $mqs = array(
    'mobile' => '0',
    'tablet' => '41em',
    'desktop' => '65em',
    'desktop-large' => '114em'
  );

  return $mqs;
}

/**
 * Format phone as (555) 555 - 5555
*/
function nt_format_phone( $ph = 0 ) {
  //remove all special chars
  if($ph) {
    $ph = preg_replace('/[^a-z0-9]/i', '', $ph);
  }

  //format it
  if(  preg_match( '/^(\d{3})(\d{3})(\d{4})$/', $ph,  $matches ) )
  {
    $ph = $matches[1] . '-' .$matches[2] . '-' . $matches[3];
  }

  return $ph;
}

/**
 * Return price range of restaurant as $ dollar signs.
*/
function nt_price_range( $price = 0 ) {
  $value = '';
  if( $price ) {
    for($i=0; $i < $price; $i++ ) {
      $value .= '$';
    }
  }

  return $value;
}

/**
 * return cuisines for a restaurant as comma separated string
*/
function nt_get_cuisines( $cuisines = array() ) {
  if( !empty( $cuisines ) ) {
    $results = array();
    foreach( $cuisines as $c ) {
      $results[] = $c->name;
    }

    return implode( ', ', $results );
  }
}

/**
 * return hours as string for list
*/
function nt_get_hours( $custom_fields = false ) {
  if( !$custom_fields ) {
    $custom_fields = get_post_custom();
  }

  $hours = '<span>';
  $hours .= isset( $custom_fields['nt_cpt_rest_hrs_m_f'] ) ? '<div>Mon-Fri ' . $custom_fields['nt_cpt_rest_hrs_m_f'][0] . '</div>' : '';
  $hours .= isset( $custom_fields['nt_cpt_rest_hrs_s_s'] ) ? '<div>Sat-Sun ' . $custom_fields['nt_cpt_rest_hrs_s_s'][0] . '</div>' : '';
  $hours .= isset( $custom_fields['nt_cpt_rest_hrs_all'] ) ? '<div>Everyday ' . $custom_fields['nt_cpt_rest_hrs_all'][0] . '</div>' : '';
  $hours .= isset( $custom_fields['nt_cpt_rest_hrs_mon'] ) ? '<div>Mon ' . $custom_fields['nt_cpt_rest_hrs_mon'][0] . '</div>' : '';
  $hours .= isset( $custom_fields['nt_cpt_rest_hrs_tue'] ) ? '<div>Tue ' . $custom_fields['nt_cpt_rest_hrs_tue'][0] . '</div>' : '';
  $hours .= isset( $custom_fields['nt_cpt_rest_hrs_wed'] ) ? '<div>Wed ' . $custom_fields['nt_cpt_rest_hrs_wed'][0] . '</div>' : '';
  $hours .= isset( $custom_fields['nt_cpt_rest_hrs_thu'] ) ? '<div>Thu ' . $custom_fields['nt_cpt_rest_hrs_thu'][0] . '</div>' : '';
  $hours .= isset( $custom_fields['nt_cpt_rest_hrs_fri'] ) ? '<div>Fri ' . $custom_fields['nt_cpt_rest_hrs_fri'][0] . '</div>' : '';
  $hours .= isset( $custom_fields['nt_cpt_rest_hrs_sat'] ) ? '<div>Sat ' . $custom_fields['nt_cpt_rest_hrs_sat'][0] . '</div>' : '';
  $hours .= isset( $custom_fields['nt_cpt_rest_hrs_sun'] ) ? '<div>Sun ' . $custom_fields['nt_cpt_rest_hrs_sun'][0]. '</div>' : '';
  $hours .= isset( $custom_fields['nt_cpt_rest_hrs_holidays'] ) ? '<div>Holidays ' . $custom_fields['nt_cpt_rest_hrs_holidays'][0] . '</div>' : '';
  $hours .= '</span>';

  return $hours;
}