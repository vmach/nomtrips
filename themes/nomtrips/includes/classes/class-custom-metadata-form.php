<?php
/*
@author Suniel Sambasivan <suniel.sambasivan@ama.ab.ca>
Description: Creates a form and prints out its fields using custom metadata plugin api
Usage: 
$form = new Custom_Metadata_Form( 'my_form', array('my_custom_post_type_slug') );

declare metabox:
$myform->set_form_item(array('name' => 'my_meta_box', 'post_type' => array('post', array('my_custom_post_type_slug')), 'item_type' => 'metabox',
'fields' => array('label' => 'name','description' => '...')

declare field:
$myform->set_form_item(array('name' => 'my_field', 'post_type' => array('post', 'my_custom_post_type_slug'), 'item_type' => 'field',
'fields' => array('group' => 'my_meta_box', 'field_type' => 'text', label' => 'name','description' => '...', )
));

declare fieldset:
//fieldsets use a callback option from custom metadata plugin by calling static function
$myform->set_form_item( array('name' => 'my_fieldset','post_type' => $post_types,'item_type' => 'field', 'fields' => array(
'group' => 'gv_event_info','display_callback' => 'Custom_Metadata_Form::fieldset_start_callback','values' =>array('legend' => 'ABC', 'class' => 'my-class'))
));

see examples of field arguments: https://github.com/Automattic/custom-metadata/blob/master/custom_metadata_examples.php
*/

class Custom_Metadata_Form
{ 
  /**
  * public variables
  */
  public $form_name;
  public $post_types;
  public $form;
    
  public function __construct( $name, $posts_types ) {
    $this->form_name = $name;
    $this->post_types = $posts_types;
  }
  
  public function set_post_types( $post_types = array() ) {
    $this->post_types = $posts_types;
  }
  
  public function set_form_item( $args = array() ) {
    if( !isset( $args['post_type'] ) ) {
      $args['post_type'] = $this->post_types;
    }
    $this->form[] = $args;
  }
  
  public static function fieldset_start_callback( $field_slug, $field, $object_type, $object_id, $value ) {
    $class = isset( $field->values['class'] ) ? ' class="' . esc_attr( $field->values['class'] ) . '"' : '';
    $legend = isset( $field->values['legend'] ) ? '<legend>' . esc_html( $field->values['legend'] ) . '</legend>' : '';
    echo '<fieldset' .$class. '>';
    echo $legend;
  }
  
  public static function fieldset_end_callback() {
    echo '</fieldset>';
  }
  
  public function print_form() {
    if( !empty( $this->form ) ) {
      foreach( $this->form as $f ) {
        switch( $f['item_type'] ) {
          case 'metabox':
            echo x_add_metadata_group(
              $f['name'],
              $f['post_type'],
              $f['fields']
            );
          break;
          
          case 'field':
            echo x_add_metadata_field(
              $f['name'],
              $f['post_type'],
              $f['fields']
            );
          break;
        
          case 'multifield':
            echo x_add_metadata_multifield(
              $f['name'],
              $f['post_type'],
              $f['fields']
            );
          break;
        }
      }
    }
  }
}