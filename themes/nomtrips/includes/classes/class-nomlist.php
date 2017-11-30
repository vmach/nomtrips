<?php
/**
 * Description: Nomlist is a list of restaurants that a user has flagged in a particular city
*/

class Nomlist
{
  public $nomlist;
  public $nomlist_id;
  public $city_id;
  public $user_id;
  public $restaurant_list;
  public $is_valid_user;
  public $error;
  public $message;
  public $query;
  public $num_of_nomlists;
  public $last_rest_added;

  public function __construct( $city_id = false, $user_id = false ) {
    if(!$city_id || !$user_id) {
      $this->error = 'You need a city id and a user id';
      throw new Exception($this->error);
    }

    else {
      $this->city_id = $city_id;
      $this->user_id = $user_id;
    }

    $valid_user = $this->is_user_valid();
    if($valid_user) {      
      $this->update_nomlist_id();
    } else {
      $this->error = 'Invalid User';
      throw new Exception($this->error);
    }
  }
  
  /**
    * create nomlist in db
  **/
  private function update_nomlist_id() {
    if ($this->city_id && $this->user_id) {
      $nomlist = $this->get_nomlist();
      if(!$nomlist) {
        $this->nomlist_id = 0;
      }
      
    }

    else {
      $this->error = 'Invalid User or city id';
      throw new Exception($this->error);
    }
    //adds to db if not user doesnt already have a nomlist for city
    
  }

  /**
    * delete nomlist in db
  **/
  private function deleteNomlist() {

  }

  /**
    * save restaurant to nomlist in db
  **/
  public function add_restaurant_to_nomlist($rest_id = 0) {
    /* $wpdb->insert( $table, $data, $format ); */
    if($rest_id) {
      $rest = get_post($rest_id);
      if($rest !== null) {
        //don't add if rest already on nomlist for this user
        if($this->nomlist_id) {
          $items = $this->getRestFromNomlist($this->user_id, $this->nomlist_id, $rest_id);
          if(empty($items)) {
            //nt_debug($items); die;
            global $wpdb;
            $insert = $wpdb->insert( 
              'nt_nomlist_item', 
              array( 
                'user_id' => $this->user_id, 
                'restaurant_id' => $rest_id,
                'nomlist_id' => $this->nomlist_id
              ), 
              array('%d', '%d', '%d')
            );
            
            if($insert) {
              $this->last_rest_added = $insert;      
              $this->message = "restaurant successfully added";      
            }

            else {
              $this->error = 'You need a city id and a user id';
              $this->message = 'You need a city id and a user id';
            }
          }

          else {
            $this->message = "Already added!";
          }
          return $this;
        }
      }
    }
  }

  /**
    * delete restaurant from nomlist in db
  **/
  private function removeRestaurantFromNomlist($rest_id) {

  }

  private function is_user_valid() {
    $user = get_user_by('ID', $this->user_id);

    if(!$user) {
      return 0;
    } else {
      return 1;
    }
  }

  public function getNomlistID($user_id = false, $city_id = false) {
    $city_id = !$city_id ? $this->city_id : $city_id;
    $user_id = !$user_id ? $this->user_id : $user_id;
    
    if($city_id && $user_id) {
      $this->get_nomlist();
    } 
    else {
      $this->nomlist_id = 0;
      $this->error = 'Couldnt Find nomlist id';
    }

    return $this->nomlist_id;
  }

  public function getRestFromNomlist($user_id = false, $nomlist_id = false, $rest_id = false) {    
    $user_id = !$user_id ? $this->user_id : $user_id;
    $nomlist_id = !$nomlist_id ? $this->nomlist_id : $nomlist_id;
    $items = false;
    if($user_id && $nomlist_id && $rest_id) {
      global $wpdb;
      $select = "
        SELECT  restaurant_id, item_id FROM nt_nomlist_item
        WHERE restaurant_id = %d and nomlist_id = %d and user_id = %d";

      $items = $wpdb->get_results( $wpdb->prepare($select, $rest_id, $nomlist_id, $user_id ) );
    }

    return $items;
  }

  public function get_nomlist() {
    /**
    * gets list of restaurants in city that a user has added
    **/
    //array of objects
    $nomlist = array();

    $q_args = array(
      'author' => $this->user_id,
      'orderby' => 'post_date',
      'order' => 'DESC',
      'posts_per_page' => 1,
      'post_type' => 'nomlist',
      'tax_query' => array(
        array(
          'taxonomy' => 'city',
          'field' => 'id',
          'terms' => $this->city_id
        )
      )
    );

    $query = new WP_Query( $q_args );
    $this->query = json_decode(json_encode($query), true);
    $this->num_of_nomlists = $query->found_posts;
    if ($this->num_of_nomlists < 1) {
      $this->nomlist_id = 0;
      $this->error = 'No nomlists';      
    } else {
      $this->nomlist = json_decode(json_encode($query->get_posts()));
      $this->nomlist_id = $this->nomlist[0]->ID;
    }
    return $this->nomlist_id;
  }

  //Get cities for user where there's a nomlist
  public static function get_city_list($user_id = false) {
    if(!$user_id){
      $user_id = is_user_valid();
    }

    if($user_id > 0) {
      global $wpdb;
      $select = "
        SELECT a.city_id as CityID,
        b.name as CityName FROM nt_nomlists a
        INNER JOIN wp_terms b ON b.term_id = a.city_id
        WHERE a.user_id = %d";

      $cities = $wpdb->get_results( $wpdb->prepare($select, $user_id) );
      return $cities;
    }

    else {
      return 0;
    }
  }

  /**
   * return list of restuarants in nomlist
   **/
  public function get_restaurants_in_nomlist_by_id($nomlist_id = false) {
    if($nomlist_id) {
      global $wpdb;
      $items = false;
      $select = "
      SELECT  a.nomlist_id, a.user_id, a.restaurant_id, b.post_title, b.post_name, b.post_content
      FROM nt_nomlist_item as a
      INNER JOIN wp_posts as b
      ON a.restaurant_id = b.ID
      WHERE nomlist_id = %d";
      $items = $wpdb->get_results( $wpdb->prepare($select, $nomlist_id ) );
      return $items;
    }

    else {
      $this->error = 'Couldnt Find nomlist id';
      return false;
    }
  }
}

