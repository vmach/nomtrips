<?php
/**
 * Description: Post object
*/

class Nomtrip_Post
{
  public $post;
  public $post_id;
  public $slug;
  public $post_type;

  public function __construct( $id = false ) {
    if(!$id) {
      $this->post_id = get_the_ID();
    }

    else {
      $this->post_id = $id;
    }

    $this->post = get_post( $id );
    $this->slug = $this->post->slug;
    $this->post_type = $this->post->post_type;
  }

  public function get_post_restaurant() {
    /**
    * sees if there is an assoicated restaurant with this post.
    * return restaurant object if found.
    * return false if not
    **/

    $post_restaurant = get_post_meta( $this->post_id, 'restaurant_review' );

    return $post_restaurant;
  }
}