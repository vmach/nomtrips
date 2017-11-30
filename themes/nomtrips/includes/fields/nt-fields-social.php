<?php

/*
Fields shared by multiple content types
*/

add_action( 'custom_metadata_manager_init_metadata', function() {
  
  $post_types = array( 'restaurant', 'user' );
  
  $social_form = new Custom_Metadata_Form( 'social-form', $post_types );
  
  $social_form->set_form_item( array(
    'name' => 'nt_cpt_fields_social', 
    'item_type' => 'metabox',
    'fields' => array(
      'label' => 'Social Media', 
      )
  ) );
  
  $social_form->set_form_item( array(
    'name' => 'nt_cpt_twitter',
    'item_type' => 'field',
    'fields' => array(
      'group' => 'nt_cpt_fields_social',
      'label' => 'Twitter',
      'field_type' => 'link'
    )
  ) );
  
  $social_form->set_form_item( array(
    'name' => 'nt_cpt_facebook',
    'item_type' => 'field',
    'fields' => array(
      'group' => 'nt_cpt_fields_social',
      'label' => 'Facebook',
      'field_type' => 'link'
    )
  ) );
  
  $social_form->set_form_item( array(
    'name' => 'nt_cpt_Instagram',
    'item_type' => 'field',
    'fields' => array(
      'group' => 'nt_cpt_fields_social',
      'label' => 'Instagram',
      'field_type' => 'link'
    )
  ) );
  
  $social_form->set_form_item( array(
    'name' => 'nt_cpt_google_plus',
    'item_type' => 'field',
    'fields' => array(
      'group' => 'nt_cpt_fields_social',
      'label' => 'Google+',
      'field_type' => 'link'
    )
  ) );
  
  $social_form->print_form();
});