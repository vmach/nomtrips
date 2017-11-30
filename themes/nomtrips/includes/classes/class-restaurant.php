<?php

/**
 * Restaurant Class
 *
 * @file                 class-restaurant.php
 * @package            NomTrips
 * @author              Suniel Sambasivan
 * @copyright           2016 Suniel Sambasivan
 * @description         Creates a restaurant object by restaurant post id
 */

class Restaurant {
  public $restaurant_id;
  public $restaurant_name;
  public $restaurant_slug;
  public $restaurant_url;
  public $latitude;
  public $longitude;
  public $restaurant_location;
  public $restaurant_address_string;
  public $restaurant_contact_info;
  public $restaurant_social;
  public $restaurant_price;
  public $restaurant_rating;
  public $restaurant_cuisines;
  public $restaurant_hours;
  public $restaurant_dining_type;
  public $restaurant_status;
  public $restaurant_featured_img;
  public $error;

  private $post_obj;
  private $custom_fields;

  public function __construct( $id = false, $post = false ) {

    //Check if invalid id passed or page is not a post
    if( !$id ) {
      if( !get_the_id() ) {
        $this->restaurant_id = false;
        $this->error = 'Could not retrieve post ID';
        throw new Exception($this->error);
      }

      else {
        //use current post id
        $this->post_obj = get_post( get_the_id() );
        $this->restaurant_id = $this->post_obj->ID;
        $this->restaurant_status = get_post_status( $this->restaurant_id );
      }
    }

    else {
      if( !$status = get_post_status( $id ) ) {
        $this->restaurant_id = false;
        $this->error = 'Invalid ID';
        throw new Exception($this->error);
      }

      else {
        $this->post_obj = get_post( $id );
        $this->restaurant_id = $this->post_obj->ID;
        $this->restaurant_status = $status;
      }
    }

    /**
      * now get everything about this post
    **/

    if( $this->restaurant_id ) {
      //get custom fields
      $this->custom_fields = get_post_custom( $this->restaurant_id );

      //set post fields
      $this->restaurant_name = $this->post_obj->post_title;
      $this->restaurant_slug = $this->post_obj->post_name;
      $this->restaurant_url = get_post_permalink($this->restaurant_id);
      $this->restaurant_location = $this->get_location();
      $this->restaurant_address_string = $this->get_address_string();
      $this->restaurant_contact_info = $this->get_contact_info();
      $this->restaurant_social = $this->get_social();
      $this->restaurant_price = $this->get_price();
      $this->restaurant_rating = $this->get_rating();
      $this->restaurant_cuisines = $this->get_cuisines();
      $this->restaurant_hours = $this->get_hours();
      $this->restaurant_dining_type = $this->get_dining_type();
      $this->restaurant_featured_img = $this->get_featured_img();
    }

  }// end constructor


  /**
   * return city object
  **/
  public function get_location() {
    $location = new stdClass();
    $location->address = new stdClass();

    //address coordinates
    $this->latitude =  isset( $this->custom_fields['nt_cpt_latitude'][0] ) ? $this->custom_fields['nt_cpt_latitude'][0] : false;
    $this->longitude =  isset( $this->custom_fields['nt_cpt_longitude'][0] ) ? $this->custom_fields['nt_cpt_longitude'][0] : false;
    
    //city (taxonomy)
    $cities = get_the_terms( $this->restaurant_id, 'city' );
    $location->city = isset( $cities[0]->term_id ) ? $cities[0] : false;
    $location->cityObject = $location->city ? new City($cities[0]->term_id ) : false;

    //state (nt_state-prov)
    $location->state = $location->city ? get_term_meta( $location->city->term_id, 'nt_state-prov', true ) :  false;

    //neighborhood (taxonomy)
    $neighborhoods = get_the_terms( $this->restaurant_id, 'neighborhood' );
    $location->neighborhood = isset( $neighborhoods[0]->term_id ) ? $neighborhoods[0] : false;

    //address
    $location->address->building_no = isset( $this->custom_fields['nt_cpt_building_no'][0] ) ? $this->custom_fields['nt_cpt_building_no'][0] : false;
    $location->address->street = isset( $this->custom_fields['nt_cpt_street'][0] ) ? $this->custom_fields['nt_cpt_street'][0] : false;
    $location->address->zip = isset( $this->custom_fields['nt_cpt_zip'][0] ) ? $this->custom_fields['nt_cpt_zip'][0] : false;
    $location->address->suite = isset( $this->custom_fields['nt_cpt_suite_no'][0] ) ? $this->custom_fields['nt_cpt_suite_no'][0] : false;

    return $location;
  }


  /**
   * return contact info object
  **/
  public function get_contact_info() {
    $contact_info = new stdClass();
    $contact_info->phone = isset( $this->custom_fields['nt_cpt_main_ph'][0] ) ? $this->custom_fields['nt_cpt_main_ph'][0] : false;
    $contact_info->email = isset( $this->custom_fields['nt_cpt_main_email'][0] ) ? $this->custom_fields['nt_cpt_main_email'][0] : false;
    $contact_info->web = isset( $this->custom_fields['nt_cpt_website'][0] ) ? $this->custom_fields['nt_cpt_website'][0] : false;

    return $contact_info;
  }


  /**
   * return contact info object
  **/
  public function get_social() {
    $social = new stdClass();
    $social->twitter = isset( $this->custom_fields['nt_cpt_twitter'][0] ) ? $this->custom_fields['nt_cpt_twitter'][0] : false;
    $social->facebook = isset( $this->custom_fields['nt_cpt_facebook'][0] ) ? $this->custom_fields['nt_cpt_facebook'][0] : false;
    $social->instagram = isset( $this->custom_fields['nt_cpt_Instagram'][0] ) ? $this->custom_fields['nt_cpt_Instagram'][0] : false;
    $social->google = isset( $this->custom_fields['nt_cpt_google_plus'][0] ) ? $this->custom_fields['nt_cpt_google_plus'][0] : false;

    return $social;
  }


  /**
   * return price object
  **/
  public function get_price( $price_level = false ) {
    $price = new stdClass();

    //Value of
    if( !$price_level ) {
      $price->value = isset( $this->custom_fields['nt_cpt_cost'][0] ) ? $this->custom_fields['nt_cpt_cost'][0] : false;
    } else {
      (int)$price->value = $price_level;
    }


    //Return price range of restaurant as $dollar signs.
    $value = '';
    if( $price->value ) {
      for($i=0; $i < $price->value; $i++ ) {
        $value .= '$';
      }
    }

    $price->string = $value;

    return $price;
  }

  /**
   * return price object
  **/
  public function get_rating() {
    $rating = new stdClass();

    //value of
    $rating->value = isset( $this->custom_fields['nt_cpt_rating'][0] ) ? $this->custom_fields['nt_cpt_rating'][0] : false;

    return $rating;
  }


  /**
   * return address string
  **/
  public function get_address_string() {
    $address = array();
    $address['suiteno'] = isset( $this->restaurant_location->address->suite ) ? $this->restaurant_location->address->suite : '';
    $address['buildingno'] = isset( $this->restaurant_location->address->building_no ) ? $this->restaurant_location->address->building_no : '';
    $address['street'] = isset( $this->restaurant_location->address->street ) ? $this->restaurant_location->address->street : '';
    $address['zip'] = isset( $this->restaurant_location->address->zip ) ? $this->restaurant_location->address->zip : '';
    $address['city'] = isset( $this->restaurant_location->city->name ) ? $this->restaurant_location->city->name : '';
    $address['state'] = isset( $this->restaurant_location->state ) ? $this->restaurant_location->state : '';
    $address['neighborhood'] = isset( $this->restaurant_location->neighborhood->name ) ? $this->restaurant_location->neighborhood->name : '';
    $neighborhood_string = $address['neighborhood'] != '' ? ', ' . $address['neighborhood'] : '';
    $suite_string = $address['suiteno'] != '' ? $address['suiteno'] . ' &ndash; ' : '';
    $address_string = $suite_string . $address['buildingno'] . ' ' . $address['street'] .  $neighborhood_string . ', ' . $address['city'] . ', ' . $address['state'] . ' ' .$address['zip'];
    return $address_string;
  }


  /**
   * return cuisines object with an array of terms and as a string
  **/
  public function get_cuisines() {
    $cuisines = new stdClass();

    //cuisines for a restaurant as array of terms
    $cuisines->terms = get_the_terms( $this->restaurant_id, 'cuisine' );

    //cuisines for a restaurant as comma separated string
    if( !empty( $cuisines->terms ) ) {
      $results = array();
      foreach( $cuisines->terms as $c ) {
        $results[] = $c->name;
        $urls[] = array( $c->name, get_term_link( $c->term_id, 'cuisine' ) );
      }

      $cuisines->string = implode( ', ', $results );
      $cuisines->urls = $urls;
    }

    return $cuisines;
  }


  /**
   * return hours as array and as html in object
  **/
  public function get_hours() {
    $hours = new stdClass();
    $hours->days = new stdClass();

    //as object
    $hours->days->m_f = isset( $this->custom_fields['nt_cpt_rest_hrs_m_f'] ) ? $this->custom_fields['nt_cpt_rest_hrs_m_f'][0] : '';
    $hours->days->s_s = isset( $this->custom_fields['nt_cpt_rest_hrs_s_s'] ) ? $this->custom_fields['nt_cpt_rest_hrs_s_s'][0] : '';
    $hours->days->all = isset( $this->custom_fields['nt_cpt_rest_hrs_all'] ) ? $this->custom_fields['nt_cpt_rest_hrs_all'][0] : '';
    $hours->days->mon = isset( $this->custom_fields['nt_cpt_rest_hrs_mon'] ) ? $this->custom_fields['nt_cpt_rest_hrs_mon'][0] : '';
    $hours->days->tue = isset( $this->custom_fields['nt_cpt_rest_hrs_tue'] ) ? $this->custom_fields['nt_cpt_rest_hrs_tue'][0] : '';
    $hours->days->wed = isset( $this->custom_fields['nt_cpt_rest_hrs_wed'] ) ? $this->custom_fields['nt_cpt_rest_hrs_wed'][0] : '';
    $hours->days->thu = isset( $this->custom_fields['nt_cpt_rest_hrs_thu'] ) ? $this->custom_fields['nt_cpt_rest_hrs_thu'][0] : '';
    $hours->days->fri = isset( $this->custom_fields['nt_cpt_rest_hrs_fri'] ) ? $this->custom_fields['nt_cpt_rest_hrs_fri'][0] : '';
    $hours->days->sat = isset( $this->custom_fields['nt_cpt_rest_hrs_sat'] ) ? $this->custom_fields['nt_cpt_rest_hrs_sat'][0] : '';
    $hours->days->sun = isset( $this->custom_fields['nt_cpt_rest_hrs_sun'] ) ? $this->custom_fields['nt_cpt_rest_hrs_sun'][0]: '';
    $hours->days->holidays = isset( $this->custom_fields['nt_cpt_rest_hrs_holidays'] ) ? $this->custom_fields['nt_cpt_rest_hrs_holidays'][0] : '';

    //as html
    $hours->html = '<ul class="restaurant-hours">';
    $hours->html .= isset( $this->custom_fields['nt_cpt_rest_hrs_m_f'] ) ? '<li>Mon-Fri ' . $this->custom_fields['nt_cpt_rest_hrs_m_f'][0] . '</li>' : '';
    $hours->html .= isset( $this->custom_fields['nt_cpt_rest_hrs_s_s'] ) ? '<li>Sat-Sun ' . $this->custom_fields['nt_cpt_rest_hrs_s_s'][0] . '</li>' : '';
    $hours->html .= isset( $this->custom_fields['nt_cpt_rest_hrs_all'] ) ? '<li>Everyday ' . $this->custom_fields['nt_cpt_rest_hrs_all'][0] . '</li>' : '';
    $hours->html .= isset( $this->custom_fields['nt_cpt_rest_hrs_mon'] ) ? '<li>Mon ' . $this->custom_fields['nt_cpt_rest_hrs_mon'][0] . '</li>' : '';
    $hours->html .= isset( $this->custom_fields['nt_cpt_rest_hrs_tue'] ) ? '<li>Tue ' . $this->custom_fields['nt_cpt_rest_hrs_tue'][0] . '</li>' : '';
    $hours->html .= isset( $this->custom_fields['nt_cpt_rest_hrs_wed'] ) ? '<li>Wed ' . $this->custom_fields['nt_cpt_rest_hrs_wed'][0] . '</li>' : '';
    $hours->html .= isset( $this->custom_fields['nt_cpt_rest_hrs_thu'] ) ? '<li>Thu ' . $this->custom_fields['nt_cpt_rest_hrs_thu'][0] . '</li>' : '';
    $hours->html .= isset( $this->custom_fields['nt_cpt_rest_hrs_fri'] ) ? '<li>Fri ' . $this->custom_fields['nt_cpt_rest_hrs_fri'][0] . '</li>' : '';
    $hours->html .= isset( $this->custom_fields['nt_cpt_rest_hrs_sat'] ) ? '<li>Sat ' . $this->custom_fields['nt_cpt_rest_hrs_sat'][0] . '</li>' : '';
    $hours->html .= isset( $this->custom_fields['nt_cpt_rest_hrs_sun'] ) ? '<li>Sun ' . $this->custom_fields['nt_cpt_rest_hrs_sun'][0]. '</li>' : '';
    $hours->html .= isset( $this->custom_fields['nt_cpt_rest_hrs_holidays'] ) ? '<li>Holidays ' . $this->custom_fields['nt_cpt_rest_hrs_holidays'][0] . '</li>' : '';
    $hours->html .= '</ul>';

    return $hours;
  }


  /**
   * return dining type (taxonomy: restaurant_type) object with an array of terms and as a string
  **/
  public function get_dining_type() {
    $dining_types = new stdClass();

    //cuisines for a restaurant as array of terms
    $dining_types->terms = get_the_terms( $this->restaurant_id, 'restaurant_type' );

    //cuisines for a restaurant as comma separated string
    if( !empty( $dining_types->terms ) ) {
      $results = array();
      $urls = array();
      foreach( $dining_types->terms as $d ) {
        $results[] = $d->name;
        $urls[] = array( $d->name, get_term_link( $d->term_id, 'restaurant_type' ) );
      }

      $dining_types->string = implode( ', ', $results );
      $dining_types->urls = $urls;
    }

    return $dining_types;
  }


  /**
   * return featured image as object
  **/
  public function get_featured_img() {
    return nt_get_featured_images_sizes_for_post( $this->restaurant_id );
  }

} //end class