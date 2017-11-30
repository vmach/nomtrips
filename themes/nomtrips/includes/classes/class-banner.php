<?php
/**
 * Description: creates banner object
*/

class Banner 
{
  public function __construct() {
    $this->page_id = get_queried_object_id();
    $this->thumbnail_id = get_post_thumbnail_id();
  }
  
  public function get_banner_images() {
    $image_urls = array();
    $sizes = array('banner-xlarge', 'banner-large', 'banner-medium', 'banner-small' );
    
    foreach( $sizes as $s ) {
      $image_urls[] = wp_get_attachment_image_src( $this->thumbnail_id, $s );
    }
    
    return $image_urls;
  }
}