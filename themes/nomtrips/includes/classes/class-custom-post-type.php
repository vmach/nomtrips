<?
/*
Description: Class to create a content type, taxonomy, and associated roles and permissions
@author Suniel Sambasivan <suniel.sambasivan@ama.ab.ca>
Reference: https://code.tutsplus.com/articles/custom-post-type-helper-class--wp-25104
Usage: 
$my_post_type = new Custom_Post_Type( 'My Post Type', $args, $roles, $permissions, $labels );
$my_post_type->add_taxonomy( 'My Taxonomy', $args, $capabilities, $labels );
$args, $roles, capabilities and $labels are arrays that will override or merge with the default values defined in the class
To see argument options see:
https://codex.wordpress.org/Function_Reference/register_post_type 
https://codex.wordpress.org/Function_Reference/register_taxonomy
*/
class Custom_Post_Type
{  
  /* Class constructor */
  public function __construct( $name, $args = array(), $roles = array(), $capabilities = array(), $permissions = array(), $labels = array() ) {

    $this->post_type_name = self::uglify( $name );
    $this->post_type_args = $args;
    $this->post_type_roles = $roles;
    $this->post_type_capabilities = $capabilities;
    $this->post_type_permissions = $permissions;
    $this->post_type_labels = $labels;
    
    // Add action to register the post type, if the post type does not already exist
    if( ! post_type_exists( $this->post_type_name ) ){
      add_action( 'init', array( &$this, 'register_post_type' ) );
    }
    
    $capabilities = array_merge(
      //default
      array(
        'publish_posts' => 'publish_' . $this->post_type_name,
        'edit_posts' => 'edit_' . $this->post_type_name,
        'edit_others_posts' => 'edit_others_' . $this->post_type_name,
        'delete_posts' => 'delete_' . $this->post_type_name,
        'delete_others_posts' => 'delete_others_' . $this->post_type_name,
        'read_private_posts' => 'read_private_' . $this->post_type_name,
        'edit_post' => 'edit_' . $this->post_type_name,
        'delete_post' => 'delete_' . $this->post_type_name,
        'read_post' => 'read_' . $this->post_type_name
      ),
      // Given args
      $this->post_type_capabilities
    );
    $this->post_type_capabilities = $capabilities;
    
    //ama_debug($this->post_type_capabilities);
    $this->add_roles( $this->post_type_roles, $this->post_type_permissions );
  }
  
  /* Method which registers the post type */
  public function register_post_type() {
    $name = self::beautify( $this->post_type_name );
    $plural = self::pluralize( $name );
   
    // We set the default labels based on the post type name and plural. We overwrite them with the given labels.
    $labels = array_merge(
      // Default
      array(
        'name' => _x( $plural, $this->post_type_name ),
        'singular_name' => _x( $name, $this->post_type_name ),
        'menu_name' => _x( $name, $this->post_type_name ),
        'add_new' => _x( 'Add New', strtolower( $name ) ),
        'add_new_item' => __( 'Add New ' . $name ),
        'edit_item' => __( 'Edit ' . $name ),
        'new_item' => __( 'New ' . $name ),
        'all_items' => __( 'All ' . $plural ),
        'view_item' => __( 'View ' . $name ),
        'search_items' => __( 'Search ' . $plural ),
        'not_found' => __( 'No ' . strtolower( $plural ) . ' found'),
        'not_found_in_trash' => __( 'No ' . strtolower( $plural ) . ' found in Trash'), 
        'parent_item_colon' => '',
        'menu_name' => $plural
      ),
      // Given labels
      $this->post_type_labels
    );
    
    $args = array_merge(
      // Default
      array(
      'label' => $plural,
      'labels' => $labels,
      'public' => true,
      'show_ui' => true,
      'supports' => array( 'title', 'editor' ),
      'show_in_nav_menus' => true,
      '_builtin' => false,
      'capability_type' => $this->post_type_name,
      'capabilities' => $this->post_type_capabilities,
      ),
      // Given args
      $this->post_type_args
    );
   
    // Register the post type
    register_post_type( $this->post_type_name, $args );
  }
  
  public function add_roles( $roles, $perms ) {
    $obj = $this;
    add_action( 'after_setup_theme', function() use( $obj, $roles, $perms ){
      //give default capabilties
      $permissions = array();
      foreach( $obj->post_type_capabilities as $key => $value ) {
        $permissions[$value] = true;
      }
    
      //add passed capabilities
      if( !empty( $perms ) ) {
        foreach( $perms as $p ) {
          $permissions[$p] = true;
        }
      }
      
      if( !empty( $roles ) ) {
        foreach( $roles as $role ) {
          $r = get_role( $role ); //returns role object
           foreach( $permissions as $key => $value ) {
            $r->add_cap( $key ); //adds capabilities (permissions) to role
          }
        }
      }
    } );
  }
  
  /* Method to attach the taxonomy to the post type */
  public function add_taxonomy( $name, $args = array(), $capabilities = array(), $labels = array() ) {
    if( ! empty( $name ) ) {
      
      $post_type_name = $this->post_type_name;
      
      // Taxonomy properties
      $taxonomy_name = self::uglify( $name );
      $taxonomy_labels = $labels;
      $taxonomy_args = $args;
      $taxonomy_capabilities = $capabilities;
 
      if( ! taxonomy_exists( $taxonomy_name ) ) {
        $name = self::beautify( $name );
        $plural = self::pluralize( $name );
 
        // Default labels, overwrite them with the given labels.
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
          $taxonomy_labels
        );
        
        $capabilities = $this->merge_caps( $taxonomy_args, $taxonomy_capabilities );

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
          $taxonomy_args
        );
 
        // Add the taxonomy to the post type
        add_action( 
          'init',
          function() use( $taxonomy_name, $post_type_name, $args ) {
            register_taxonomy( $taxonomy_name, $post_type_name, $args );
            }
        );
      }
      
      else {
        /* The taxonomy already exists. We are going to attach the existing taxonomy to the object type (post type) */
        add_action( 
          'init',
          function() use( $taxonomy_name, $post_type_name ) {
            register_taxonomy_for_object_type( $taxonomy_name, $post_type_name );
          }
        );
      }
    }
  }
  
  private function merge_caps( $taxonomy_args, $taxonomy_capabilities ) {
    //Theres 2 ways to specify capabilities: within the $args variable as an array or passed a param declaring this taxonomy
    $caps = isset( $taxonomy_args['capabilities'] ) ? $taxonomy_args['capabilities'] : $taxonomy_capabilities;
    $caps = array_merge(
      //default
      array( 'assign_terms' => 'edit_' . $this->post_type_name ),
      //passed
      $caps
    );
    return $caps;
  }
  
  public static function beautify( $string ) {
    return ucwords( str_replace( '_', ' ', $string ) );
  }
 
  public static function uglify( $string ) {
    return strtolower( str_replace( ' ', '_', $string ) );
  }
  
  public static function pluralize( $string ) {
    $last = $string[strlen( $string ) - 1];
    //pluralizing based on whether or not it ends with 'y'. Example: 'Activity'
    if( $last == 'y' ) {
      $cut = substr( $string, 0, -1 );
      //convert y to ies
      $plural = $cut . 'ies';
    }
    elseif( $last == 's' ) {
      //if already ends in 's' don't do anything
      $plural = $string;
    }
    else {
      // just attach an s
      $plural = $string . 's';
    }
    return $plural;
  }
}