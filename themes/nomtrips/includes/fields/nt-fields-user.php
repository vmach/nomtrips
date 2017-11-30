<?php

add_action( 'custom_metadata_manager_init_metadata', function() {
  
  $post_types = array( 'user' );
  
  $user_form = new Custom_Metadata_Form( 'user-form', $post_types );
  
  $user_form->set_form_item( array(
    'name' => 'nt_usr_fields_location', 
    'item_type' => 'metabox',
    'fields' => array(
      'label' => 'Location', 
      )
  ) );
  
  $user_form->set_form_item( array(
    'name' => 'nt_usr_city',
    'item_type' => 'field',
    'fields' => array(
      'group' => 'nt_usr_fields_location',
      'label' => 'Your City',
    )
  ) );
  
  $user_form->print_form();
});