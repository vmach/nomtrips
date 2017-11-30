<?php

/***
 * Class for creating carousel.
 * Uses WP_Query object to get posts based on post_type, taxonomy and terms parameters that are passed.
***/

class Carousel
{
  public $post_type;
  public $num_posts;
  public $taxonomy;
  public $terms;
  public $posts;
  public $display_types;
  public $error;

  public function __construct( $post_type = 'false', $num_posts = 5, $taxonomy = 'category', $terms = array() ) {
    if( !$post_type ) {
      $this->error = 'Need post type';
    }

    else {
      $this->post_type = $post_type;
      $this->num_posts = $num_posts;
      $this->taxonomy = $taxonomy;
      $this->terms = $terms;
    }

    $this->display_types = array(
      'map-overlay' => 'cardsCarouselPageMap',
      'restaurant-page' => 'cardsCarouselPageRestaurant'
    );
  }

  public function get_posts() {
    //see if taxonomy terms supplied
    if( !empty($this->terms) ) {
      $tax_query = array(
        array(
          'taxonomy' => $this->taxonomy,
          'field' => 'slug',
          'terms' => $this->terms
        )
      );
    }

    //set up args
    $args = array(
      'post_type' => $this->post_type,
      'posts_per_page' => $this->num_posts,
      'tax_query' => $tax_query
    );

    $this->posts = new WP_Query( $args );
  }

  public function show_posts($display_type) {
    $this->get_posts();

    if( $display_type == 'map-overlay' ) {
      if($this->posts->have_posts()) { ?>
      <div class="map-overlay-list">
        <div class="cards--carousel cards--carousel--map-overlay" data-carousel-init="cardsCarouselPageMap">
          <!--arrow buttons-->
          <div class="cards--carousel--btn"> <button type="button" data-role="none" class="slick-prev--images slick-arrow" aria-label="Previous" role="button" style="display: block;">Previous</button> </div>

          <ul class="cards--carousel--container">
            <?php
            //get posts
            while( $this->posts->have_posts() ) {
              $this->posts->the_post();
              $restaurant = new Restaurant();
              include( locate_template( NT_COMPONENTS_PATH .'cards/card--restaurant--carousel.php') );
            }
            ?>
          </ul>

          <!--arrow buttons-->
          <div class="cards--carousel--btn"> <button type="button" data-role="none" class="slick-next--images slick-arrow" aria-label="Next" role="button" style="display: block;">Next</button> </div>
        </div>
      </div>
        <!--end list-->
      <?php
    } //if have_posts()
   } //display type
  } //end function

  public function get_restaurant_objects() {
    $this->get_posts();
    $restaurants = array();
    foreach($this->posts->posts as $p) {      
      array_push($restaurants, new Restaurant($p->ID));
    }
    return $restaurants;
  }

}