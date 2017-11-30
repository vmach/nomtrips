<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Template for displaying the footer
 *
 * @package nomtrips
 */
?>
    </section><!-- #main -->

    <div id="footer" class="footer" role="contentinfo">
      <div class="row">
        <div class="column small-12 medium-6 large-4">
          <!--site logo-->
          <a class="logo--footer" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
            <?php get_template_part(NT_COMPONENTS_PATH . 'svgs/logo'); ?>
          </a>
          <!--/site logo-->
          
          <!-- credits -->
          <div class="credits">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
              &copy; <?php bloginfo( 'name' ); ?> <?php echo date('Y') ?>
            </a>
          </div>
          <!-- /credits -->
          
          <!-- footer menu -->
          <?php wp_nav_menu( array( 'container_class' => 'nav--footer', 'menu_class' => 'menu--footer', 'theme_location' => 'menu-footer' ) ); ?>
          <!-- /footer menu -->
          
        </div>
        <!--/column-->
        
        <div class="column small-12 medium-6 large-7 large-offset-1 align-bottom flex">
          <div class="social-icons--footer push-right-tablet push-left-desktop ">
            <span class="font-size-sm text-teal">Connect with us</span>            
            <?php get_template_part(NT_COMPONENTS_PATH . 'social/social-icons', '-footer'); ?>
          </div>
        </div>
        <!--/column-->
    </div>
  </div><!-- #footer -->

</div><!-- #container -->
</div><!--off-canvas-content-->

<?php wp_footer(); ?>
</body>
</html>
