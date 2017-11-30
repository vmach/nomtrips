<?php
/*
 * Plugin Name: Foo oAuth Demo 
 * Version: 1 
 * Plugin URI: http://ieg.wnet.org/
 * Description: A simple Google oAuth demo plugin
 * Author: William Tam
 * Author URI: http://ieg.wnet.org/blog/author/tamw/
 * Requires at least: 3.6
 * Tested up to: 4.2.2 
 * 
 * @package WordPress
 * @author William Tam
 * @since 1.0.0
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 */

 /*
if ( ! defined( 'ABSPATH' ) ) exit;
class foo_oAuth_Demo { 
  private $dir;
  private $file;
  private $token;

  public function __construct( $file ) {
    $this->dir = dirname( $file );
    $this->file = $file;
    $this->token = 'foo_oauth_demo';

    // Register plugin settings
    add_action( 'admin_init' , array( $this , 'register_settings' ) );
    // Add settings page to menu
    add_action( 'admin_menu' , array( $this , 'add_menu_item' ) );
    // Add settings link to plugins page
    add_filter( 'plugin_action_links_' . plugin_basename( $this->file ) , array( $this , 'add_settings_link' ) );
    // setup meta boxes
    add_action( 'add_meta_boxes', array( $this, 'meta_box_setup' ), 20 );
    add_action( 'save_post', array( $this, 'meta_box_save' ) );  
  }

  //The next few functions set up the settings page 
  
  public function add_menu_item() {
    add_options_page( 'Foo oAuth Demo Settings' , 'Foo oAuth Demo Settings' , 'manage_options' , 'foo_oauth_demo_settings' ,  array( $this , 'settings_page' ) );
  }

  public function add_settings_link( $links ) {
    $settings_link = '<a href="options-general.php?page=foo_oauth_demo_settings">Settings</a>';
    array_push( $links, $settings_link );
    return $links;
  }

  public function register_settings() {
    register_setting( 'foo_oauth_demo_group', 'foo_oauth_demo_settings' );
    add_settings_section('settingssection1', 'Google App Settings', array( $this, 'settings_section_callback'), 'foo_oauth_demo_settings');
    // you can define EVERYTHING to create, display, and process each settings field as one line per setting below.  And all settings defined in this function are stored as a single serialized object.
    add_settings_field( 'google_app_client_id', 'Google App Client ID', array( $this, 'settings_field'), 'foo_oauth_demo_settings', 'settingssection1', array('setting' => 'foo_oauth_demo_settings', 'field' => 'google_app_client_id', 'label' => '', 'class' => 'regular-text', 'default' => 'default') );
    add_settings_field( 'google_app_client_secret', 'Google App Client Secret', array( $this, 'settings_field'), 'foo_oauth_demo_settings', 'settingssection1', array('setting' => 'foo_oauth_demo_settings', 'field' => 'google_app_client_secret', 'label' => '', 'class' => 'regular-text', 'default' => 'default') );
    add_settings_field( 'google_app_redirect_uri', 'Google App Redirect URI', array( $this, 'settings_field'), 'foo_oauth_demo_settings', 'settingssection1', array('setting' => 'foo_oauth_demo_settings', 'field' => 'google_app_redirect_uri', 'label' => '', 'class' => 'regular-text', 'default' => 'default') );
  }

  public function settings_section_callback() { echo ' '; }

  public function settings_field( $args ) {
    // This is the default processor that will handle standard text input fields.  Because it accepts a class, it can be styled or even have jQuery things (like a calendar picker) integrated in it.  Pass in a 'default' argument only if you want a non-empty default value.
    //echo '<pre>'.serialize($args).'</pre>';
    $settingname = esc_attr( $args['setting'] );
    $setting = get_option($settingname);
    $field = esc_attr( $args['field'] );
    $label = esc_attr( $args['label'] );
    $class = esc_attr( $args['class'] );    
    $default = ($args['default'] ? esc_attr( $args['default'] ) : '' );
    $value = (($setting[$field] && strlen(trim($setting[$field]))) ? $setting[$field] : $default);
    echo '<input type="text" name="' . $settingname . '[' . $field . ']" id="' . $settingname . '[' . $field . ']" class="' . $class . '" value="' . $value . '" /><p class="description">' . $label . '</p>';
  }

  public function settings_page() {
    if (!current_user_can('manage_options')) {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }
    ?>
    <div class="wrap">
      <h2>Foo oAuth Demo Settings</h2>
      <p>You'll need to go to the <a href="https://console.developers.google.com">Google Developer Console</a> to setup your project and setup the values below.</p>
      <form action="options.php" method="POST">
        <?php settings_fields( 'foo_oauth_demo_group' ); ?>
        <?php do_settings_sections( 'foo_oauth_demo_settings' ); ?>
        <?php submit_button(); ?>
      </form>
    </div>
    <?php
  }

  // This function is the clearest way to get the oAuth JavaScript onto a page as needed.
  private function write_out_oAuth_JavaScript() {
    $settings = get_option('foo_oauth_demo_settings', true);
    ?>
  <script language=javascript>
  // we declare this variable at the top level scope to make it easier to pass around
  var google_access_token = '';

  jQuery(document).ready(function($) {
    var GOOGLECLIENTID = "<?php echo $settings['google_app_client_id']; ?>";
    var GOOGLECLIENTREDIRECT = "<?php echo $settings['google_app_redirect_uri']; ?>";
    // we don't need the client secret for this, and should not expose it to the web.

  function requestGoogleoAuthCode() {
    var OAUTHURL = 'https://accounts.google.com/o/oauth2/auth';
    var SCOPE = 'profile email openid https://www.googleapis.com/auth/youtube';
    var popupurl = OAUTHURL + '?scope=' + SCOPE + '&client_id=' + GOOGLECLIENTID + '&redirect_uri=' + GOOGLECLIENTREDIRECT + '&response_type=token&prompt=select_account';
    var win =   window.open(popupurl, "googleauthwindow", 'width=800, height=600'); 
    var pollTimer = window.setInterval(function() { 
      try {
        if (win.document.URL.indexOf(GOOGLECLIENTREDIRECT) != -1) {
          window.clearInterval(pollTimer);
          var response_url = win.document.URL;
          google_access_token = gup(response_url, 'access_token');
          win.close();          
          getGoogleUserInfo(google_access_token);
        }
      } catch(e) {}    
    }, 500);
  }

  // helper function to parse out the query string params
  function gup(url, name) {
    name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
    var regexS = "[\\?#&]"+name+"=([^&#]*)";
    var regex = new RegExp( regexS );
    var results = regex.exec( url );
    if( results == null )
      return "";
    else
      return results[1];
  }

  function getGoogleUserInfo(google_access_token) {
    $.ajax({
      url: 'https://www.googleapis.com/plus/v1/people/me/openIdConnect',
      data: {
        access_token: google_access_token
      },
      success: function(resp) {
        var user = resp;
        console.log(user);
        $('#googleUserName').text('You are logged in as ' + user.name);
        loggedInToGoogle = true;
        $('#google-login-block').hide();
        $('#google-logout-block').show();
      },
      dataType: "jsonp"
    });
  }

  function logoutFromGoogle() {
    $('#googleAuthIFrame').attr("src", "https://www.google.com/accounts/Logout");
    $('#google-login-block').show();
    $('#google-logout-block').hide();
    $('#googleUserName').text('You are not logged in');
    google_access_token = '';
  }

  // We also want to setup the initial click event and page status on document.ready
   $(function() {
    $('#google-login-block').click(requestGoogleoAuthCode);
    $('#google-logout-block').hide();
    $('#google-logout-block').click(logoutFromGoogle);
   });  
  });
  </script>
  <a id="google-login-block">Login to Google </a>
  <span id="googleUserName">You are not logged in </span>
  <span id="google-logout-block"><a>Logout from Google</a></span>
  <iframe id="googleAuthIFrame" style="visibility:hidden;" width=1 height=1></iframe>
  <?php
  // END inlined JavaScript and HTML
  }

  private function write_out_youtube_js_html() {
    ?>
  <script language=javascript>
  jQuery(document).ready(function($) {
    function getYouTubeVidInfo() {
      var video_id = $('#youtubevidid').val();
      $.ajax({ 
        url: 'https://www.googleapis.com/youtube/v3/videos',
        method: 'GET',
        headers: {
          Authorization: 'Bearer ' + google_access_token
        },
        data: {
          part: 'snippet',
          id: video_id
        }
      }).done(function(response) {
        if (response.items[0].snippet){
          var thisdata = response.items[0].snippet;
          $('#youtubevideodata').html('<b>' + thisdata.title + '</b><br />' + thisdata.description);
        } 
      }); 
    }

    //write out a click event for to trigger the youtube request
    $(function() {
      $('#youtube-get-vidinfo').click(getYouTubeVidInfo);
    });
  }); 
  </script>
  <input id="youtubevidid" type=text value="5ywjpbThDpE" /><a id="youtube-get-vidinfo">Get Video Info</a>
  <div id="youtubevideodata"></div>
  <?php
  // END inlined JavaScript and HTML
  }

 //The rest of these functions build and process metaboxes for posts

  public function meta_box_setup( $post_type ) {
    add_meta_box( 'foo-oAuth-demo-display', __( 'foo oAuth Demo' , 'foo_oauth_demo' ), array( $this, 'meta_box_content' ), $post_type, 'normal', 'high' );
  }

  public function meta_box_content() {
  global $post_id;
    add_thickbox();

  $fields = get_post_custom( $post_id );
  $field_definitions = $this->get_field_definitions();
  
    // Always include a nonce 
  $html .= '<input type="hidden" name="' . $this->token . '_nonce" id="' . $this->token . '_nonce" value="' . wp_create_nonce( plugin_basename( $this->dir ) ) . '" />';
  if ( 0 < count( $field_definitions ) ) {
       $html .= '<table class="form-table">' . "\n";
      $html .= '<tbody>' . "\n";
      foreach ( $field_definitions as $field => $option ) {
        $value = $option['default'];  
     if ( isset( $fields[$field] ) && isset( $fields[$field][0] ) ) {
        $value = $fields[$field][0];
        }
        $html .= $this->format_input_field_as_tablerow($option, $field, $value); 
      } 
      $html .= '</tbody>' . "\n";
      $html .= '</table>' . "\n";
  }  
  echo $html;  
    $this->write_out_oAuth_JavaScript();
    $this->write_out_youtube_js_html();
  }

  public function meta_box_save() {
    global $post;
    $post_id=$post->ID;
    // Verify nonce
    if ( ! wp_verify_nonce( $_POST[ $this->token . '_nonce'], plugin_basename( $this->dir ) ) ) {  
    return $post_id;  
    }
    // Verify user permissions
    if ( ! current_user_can( 'edit_post', $post_id ) ) { 
      return $post_id;
    }
    // Handle custom fields
    $field_definitions = $this->get_field_definitions();
    $fieldlist = array_keys( $field_definitions );
    foreach ( $fieldlist as $field ) {
      if( isset( $_POST[$field] ) ) {
        // only operate on fields that were submitted
        $value = $_POST[$field];
        // Escape the URLs.
        if ( 'url' == $field_definitions[$field]['type'] ) {
          $value = esc_url( $value );
        }
        update_post_meta( $post_id , $field , $value );
      }
    }
  }

  public function get_field_definitions() {
    $fields = array();
    $fields['foo_oauth_demo_field'] = array(
      'name' => __( 'A field to store something in:' , 'foo_oauth_demo' ),
      'type' => 'text',
      'default' => '',
      'description' => 'So we can store things here',
      'section' => 'main'
    );
    return $fields;
  }

  private function format_input_field_as_tablerow($option, $field, $value) {
    $html = '';
    if ($option['maxlength']) { $maxinput = ' data-limit-input="' . $option['maxlength'] . '" '; }
    $html .= '<tr valign="top" class="' . $option['section'] . '"><th scope="row"><label for="' . esc_attr( $field ) . '">' . $option['name'] . '</label></th><td><input name="' . esc_attr( $field ) . '" type="text" id="' . esc_attr( $field ) . '" class="regular-text" value="' . esc_attr( $value ) . '"' . $maxinput . ' />' . "\n";
    $html .= '<span></span><p class="description">' . $option['description'] . '</p>' . "\n";
    $html .= '</td></tr>' . "\n";
    return $html;
  }
  
//end of class  
}

// Instantiate our class
global $plugin_obj;
$plugin_obj = new foo_oAuth_Demo( __FILE__ );


// always cleanup after yourself
register_deactivation_hook(__FILE__, 'foo_deactivation');

function foo_deactivation() {
  error_log('Foo has been deactivated');
}

//END OF FILE 
*/
?>