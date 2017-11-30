<?php
/**
  * Description: Itinerary uses custom Itinerary table and relationship table.
  * DB Tables {
  *   Itinerary: itinerary_id (pk), user_id (fk), city_id (fk)
  *   Itinerary_Restaurant: itinerary_id, restaurant_id
  * }
**/

class Itinerary {
  public $city_id;
  public $restaurant_list;
  public $start_date;
  public $end_date;
  public $error;

  private $user_id;

  public function __construct( $user_id = false, $city_id = false ) {
    if( $user_id ) {
      $this->user_id = $user_id;
    }

    else {
      $this->error = "No user_id provided";
      throw new Exception($this->error);
    }

    if( $city_id ) {
      $this->city = $city_id;
    }

    else {
      $this->error = "No city term_id provided";
      throw new Exception($this->error);
    }

    $this->restaurant_list = array();
  }

  /**
    * save itinerary to db
  **/
  private function saveItinerary() {

  }

  /**
    * update itinerary in db
  **/
  private function updateItinerary() {

  }

  /**
    * delete itinerary in db
  **/
  private function deleteItinerary() {

  }

  /**
    * save restaurant to itinerary in db
  **/
  private function saveRestaurantToItinerary() {

  }

  /**
    * delete restaurant from itinerary in db
  **/
  private function deleteRestaurantFromItinerary() {

  }

  /**
    * add restaurant to itinerary
    * parameters: restaurant_id //post_id of content post of type restaurant
  **/
  public function addRestaurantToItinerary( $rest_id = false ) {
    if( $rest_id ) {
        $restaurant = new Restaurant( $rest_id );
        $this->restaurant_list[] = $restaurant;
        $this->saveRestaurantToItinerary();
    }
  }

  /**
    * remove restaurant from itinerary
    * parameters: restaurant_id //post_id of content post of type restaurant
  **/
  public function removeRestaurantFromItinerary( $rest_id = false ) {
    if( $rest_id ) {
        $this->deleteRestaurantFromItinerary();
    }
  }
}