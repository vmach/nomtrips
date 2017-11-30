<nav id="nav--off-canvas" role="navigation" class="small-3 columns nav--off-canvas" data-responsive-toggle="navMainMenu" data-hide-for="medium">
  <div class="title-bar-left">
    <button class="menu-icon" type="button" data-open="offCanvasLeft"></button>
    <span class="title-bar-title"</span>
  </div>
  <div class="off-canvas off-canvas-left position-left" id="offCanvasLeft" data-off-canvas>
    <header class="header header--off-canvas">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="columns small-7" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php get_template_part(NT_COMPONENTS_PATH . 'svgs/logo', '-rev'); ?></a>
      <button class="columns small-5 close-button" aria-label="Close menu" type="button" data-close="">
        <span aria-hidden="true">×</span>
      </button>
    </header>
    <section class="menu-user">
      <div class="columns small-12">
        <?php
        $user = wp_get_current_user();
        //nt_debug($user);
        if( $user->ID ) {
          include( locate_template( NT_COMPONENTS_PATH .'menus/nav--profile--off-canvas.php') );
        }

        else {
          wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'menu-login' ) );
        }
        ?>
      </div>
    </section>
  </div>
</nav><!-- #nav -->