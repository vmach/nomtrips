<div class="small-3 medium-9 large-9">
  <div class="header--wrapper">
    <?php
    $user = wp_get_current_user();
    $is_front = !is_front_page() ? false : true;

    if(!$is_front) { ?>
      <div class="column small-7 large-6 search--header">
        <?php //search cities if not home page
        get_template_part(NT_COMPONENTS_PATH . 'forms/search', '-header');
        ?>
      </div>
    <?php } ?>

    <div class="column small-5 large-6 nav--main">
      <?php
      if( $user->ID ) {
        include( locate_template( NT_COMPONENTS_PATH .'menus/nav--logged-in--medium.php') );
      }

      else {
        wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'menu-login' ) );
      }
      ?>
    </div>
  </div><!-- row -->
</div>