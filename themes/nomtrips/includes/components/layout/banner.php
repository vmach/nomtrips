<?php
/**
  Responsive Banner Images
  * using picturefill-background.js plugin
  * https://github.com/M6Web/picturefill-background
  * which is based on: http://scottjehl.github.io/picturefill/
**/

$banner = new Banner();
$image_array = $banner->get_banner_images();
$media_queries = nt_media_queries();

//nt_debug($image_array);

//if first is empty, assume all empty
if( !empty( $image_array[0]) ) {
  $picture_tag  = '<div class="banner-images">';
  $picture_tag .= '<span data-src="'.$image_array[3][0].'" data-media="(min-width: '.$media_queries['mobile'].')" alt="Nomtrips banner image"></span>';
  $picture_tag .= '<span data-src="'.$image_array[2][0].'" data-media="(min-width: '.$media_queries['tablet'].')"></span>';
  $picture_tag .= '<span data-src="'.$image_array[1][0].'" data-media="(min-width: '.$media_queries['desktop'].')"></span>';
  $picture_tag .= '<span data-src="'.$image_array[0][0].'" data-media="(min-width: '.$media_queries['desktop-large'].')"></span>';
  $picture_tag .= '</div>';
}

echo $picture_tag;