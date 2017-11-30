<?php
/**
 * Description: Creates a new taxonomy using register_taxonomy()
*/

class Custom_Taxonomy {
  public $taxonomy_name;
  public $taxonomy_post_types;
  public $taxonomy_args;
  public $taxonomy_capabilities;
  public $taxonomy_labels;
  public $error;

  /* Class constructor */
  public function __construct( $name = null, $post_types = array(), $args = array(), $capabilities = array(), $labels = array() ) {

    if( $name == null || empty( $post_types ) ) {
      $this->error = "No name or post_type specified";
      throw new Exception( $this->error );
    }

    $this->taxonomy_name = Custom_Post_Type::uglify( $name );
    $this->taxonomy_post_types = $post_types;
    $this->taxonomy_args = $args;
    $this->taxonomy_capabilities = $capabilities;
    $this->taxonomy_labels = $labels;

    if( ! taxonomy_exists( $this->taxonomy_name ) ) {

      $name = Custom_Post_Type::beautify( $name );
      $plural = Custom_Post_Type::pluralize( $name );

      $labels = array_merge(
        // Default
        array(
          'name'                  => _x( $plural, 'taxonomy general name' ),
          'singular_name'         => _x( $name, 'taxonomy singular name' ),
          'search_items'          => __( 'Search ' . $plural ),
          'all_items'             => __( 'All ' . $plural ),
          'parent_item'           => __( 'Parent ' . $name ),
          'parent_item_colon'     => __( 'Parent ' . $name . ':' ),
          'edit_item'             => __( 'Edit ' . $name ),
          'update_item'           => __( 'Update ' . $name ),
          'add_new_item'          => __( 'Add New ' . $name ),
          'new_item_name'         => __( 'New ' . $name . ' Name' ),
          'menu_name'             => __( $name ),
        ),
        // Given labels
        $this->taxonomy_labels
      );

      $capabilities = $this->merge_caps( $this->taxonomy_args, $this->taxonomy_capabilities );

      // Default arguments, overwritten with the given arguments
      $args = array_merge(
        // Default
        array(
          'label'                 => $plural,
          'labels'                => $labels,
          'public'                => true,
          'show_ui'               => true,
          'show_in_nav_menus'     => true,
          'hierarchical'          => true,
          '_builtin'              => false,
          'capabilities'          => $capabilities,
        ),
        // Given
        $this->taxonomy_args
      );

      // Add the taxonomy to the post types
      add_action(
        'init',
        function() use ( $args ) {
          register_taxonomy( $this->taxonomy_name, $this->taxonomy_post_types, $args );
          }
      );
    }

    else {
      /* The taxonomy already exists. We are going to attach the existing taxonomy to the object type (post type) */
      add_action(
        'init',
        function() {
          foreach( $this->taxonomy_post_types as $type ) {
            register_taxonomy_for_object_type( $this->taxonomy_name, $type );
          }
        }
      );
    }

  }

  private function merge_caps( $taxonomy_args, $taxonomy_capabilities ) {
    //Theres 2 ways to specify capabilities: within the $args variable as an array or passed a param declaring this taxonomy
    $caps = isset( $taxonomy_args['capabilities'] ) ? $taxonomy_args['capabilities'] : $taxonomy_capabilities;
    foreach( $this->taxonomy_post_types as $type ) {
      $caps = array_merge(
        //default
        array( 'assign_terms' => 'edit_' . $type ),
        //passed
        $caps
      );
    }
    return $caps;
  }
}