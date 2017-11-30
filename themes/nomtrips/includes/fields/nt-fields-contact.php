<?php

/*
Fields shared by multiple content types
*/

add_action( 'custom_metadata_manager_init_metadata', function() {
  
  $post_types = array( 'restaurant' );
  
  $contact_form = new Custom_Metadata_Form( 'social-form', $post_types );
  
  $contact_form->set_form_item( array(
    'name' => 'nt_cpt_fields_contact', 
    'item_type' => 'metabox',
    'fields' => array(
      'label' => 'Main Contact Info', 
      )
  ) );
  
  $contact_form->set_form_item( array(
    'name' => 'nt_cpt_main_ph',
    'item_type' => 'field',
    'fields' => array(
      'group' => 'nt_cpt_fields_contact',
      'label' => 'Main Phone',
    )
  ) );
  
  $contact_form->set_form_item( array(
    'name' => 'nt_cpt_main_email',
    'item_type' => 'field',
    'fields' => array(
      'group' => 'nt_cpt_fields_contact',
      'label' => 'Main Email',
      'field_type' => 'email'
    )
  ) );
  
  $contact_form->set_form_item( array(
    'name' => 'nt_cpt_website',
    'item_type' => 'field',
    'fields' => array(
      'group' => 'nt_cpt_fields_contact',
      'label' => 'Website address',
      'field_type' => 'link'
    )
  ) );
  
  $contact_form->print_form();
});