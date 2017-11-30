<?php
/**
Login Menu
**/
?>

<nav id="nav" role="navigation" class="small-3 columns nav--login">
    <?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'menu-login' ) ); ?>
</nav><!-- #nav -->

<?php
//search cities if not home page
if(!is_front_page())
  get_template_part(NT_COMPONENTS_PATH . 'forms/search', '-off-canvas-menu');
?>
