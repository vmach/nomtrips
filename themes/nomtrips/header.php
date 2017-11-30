<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;
header("Access-Control-Allow-Origin: *");
/**
 * Header template
 *
 * Displays all of the <head> section and everything up till <div id="main">.
 *
 * @package nomtrips
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
  /*
   * Print the <title> tag based on what is being viewed.
   */
  global $page, $paged;

  wp_title( '|', true, 'right' );

  // Add the blog name.
  bloginfo( 'name' );

  // Add the blog description for the home/front page.
  $site_description = get_bloginfo( 'description', 'display' );
  if ( $site_description && ( is_home() || is_front_page() ) )
    echo " | $site_description";

  // Add a page number if necessary:
  if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() )
    echo esc_html( ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) ) ); ?>
</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
  /*
   * We add some JavaScript to pages with the comment form
   * to support sites with threaded comments (when in use).
   */
  if ( is_singular() && get_option( 'thread_comments' ) )
    wp_enqueue_script( 'comment-reply' );
  /*
   * Always have wp_head() just before the closing </head>
   * tag of your theme, or you will break many plugins, which
   * generally use this hook to add elements to <head> such
   * as styles, scripts, and meta tags.
   */
  wp_head();
?>
<!-- <script>
  System.import('app').catch(function(err) { console.error(err); });
</script> -->
</head>

<?php
/**
 * Sets up global post data
*/

global $post;
setup_postdata( $post );
?>

<body <?php body_class("off-canvas-wrapper"); ?>>
  <script>
    window.fbAsyncInit = function() {
      FB.init({
        appId      : '792620280902603',
        xfbml      : true,
        version    : 'v2.9'
      });
      FB.AppEvents.logPageView();
    };

    (function(d, s, id){
       var js, fjs = d.getElementsByTagName(s)[0];
       if (d.getElementById(id)) {return;}
       js = d.createElement(s); js.id = id;
       js.src = "//connect.facebook.net/en_US/sdk.js";
       fjs.parentNode.insertBefore(js, fjs);
     }(document, 'script', 'facebook-jssdk'));
  </script>
<div id="container" class="off-canvas-wrapper-inner hfeed" data-off-canvas-wrapper>
  <div id="head" class="off-canvas-content" data-off-canvas-content>
    <header id="header" class="header title-bar">
      <div class="row header--contents">
        <!--off canvas Login menu-->
        <?php get_template_part(NT_COMPONENTS_PATH . 'menus/nav', '-off-canvas'); ?>

        <!--Site Logo-->
        <?php
        $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div'; ?>
        <<?php echo $heading_tag; ?> id="logo" class="small-9 medium-3 large-3 columns">
            <a class="logo--header" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
              <?php get_template_part(NT_COMPONENTS_PATH . 'svgs/logo', '-rev'); ?>
            </a>
        </<?php echo $heading_tag; ?>>

        <!--main login menu-->
        <?php get_template_part(NT_COMPONENTS_PATH . 'menus/nav', '-main'); ?>
      </div>
    </header>
  </div>

  <section id="main">
