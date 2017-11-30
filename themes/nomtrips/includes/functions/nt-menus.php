<?php
/**
  Declare Menus
**/

function nt_register_menus() {
  register_nav_menu('menu-login',__( 'Login Menu' ));
  register_nav_menu('menu-footer',__( 'Footer Menu' ));
  register_nav_menu('menu-itinerary',__( 'Itinerary Menu' ));
}
add_action( 'init', 'nt_register_menus' );

/**
  menu helper functions
**/
