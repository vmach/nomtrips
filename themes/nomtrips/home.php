<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
* Homepage Template
* Template Name: home
*
* @file           home.php
* @package        NomTrips
* @author         Suniel Sambasivan
* @copyright      2015 - 2016 Suniel Sambasivan
*/

get_header(); ?>

<section id="banner" class="banner picturefill-background">
  <div class="banner--inner">
    <?php
    //nt_debug($id);
      if ( has_post_thumbnail()) :
        get_template_part(NT_COMPONENTS_PATH . 'layout/banner');
      endif;
    ?>

    <div class="form-search--cities">
    <?php
      get_template_part(NT_COMPONENTS_PATH . 'forms/search', '-cities');
    ?>
    </div>
  </div>
</section>

<?php if (have_posts()) : ?>
  <?php while (have_posts()) : the_post(); ?>
  <div class="row">
    <div class="content columns small-12" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <section class="content--heading">
        <?php the_content(); ?>
      </section>
      <section class="content--post--home">
        <div class="row">
          <?php
          /* get cities */
          $city_array = array( 'new-york', 'los-angeles', 'san-diego', 'miami', 'las-vegas' ); //set order
          $image_size = 'thumb-card';

            /* show cities */
          foreach( $city_array as $city ) {
            switch( $city ) {

              case 'new-york':
              $current = City::get_city_by_slug( $city );
              $image_size = 'thumb-card';
              ?>
                <article class="columns small-12 medium-6 card--city card--city--primary">
                  <?php
                    include( locate_template( NT_COMPONENTS_PATH .'cards/card--city.php') );
                  ?>
                </article>
                <?php
              break;

              case 'los-angeles':
              $current = City::get_city_by_slug( $city );
              $image_size = 'thumb-card';
              ?>
                <article class="columns small-12 medium-6 card--city card--city--primary">
                  <?php
                    include( locate_template( NT_COMPONENTS_PATH .'cards/card--city.php') );
                  ?>
                </article>
                <?php
              break;

              case 'san-diego':
              $current = City::get_city_by_slug( $city );
              $image_size = 'thumb-card';
              ?>
                <article class="columns small-12 medium-4 card--city">
                  <?php
                    include( locate_template( NT_COMPONENTS_PATH .'cards/card--city.php') );
                  ?>
                </article>
                <?php
              break;

              case 'miami':
              $current = City::get_city_by_slug( $city );
              //$image_size = 'thumb-card-vert';
              ?>
                <article class="columns small-12 medium-4 card--city">
                  <?php
                    include( locate_template( NT_COMPONENTS_PATH .'cards/card--city.php') );
                  ?>
                </article>
                <?php
              break;

              case 'las-vegas':
              $current = City::get_city_by_slug( $city );
              $image_size = 'thumb-card';
              ?>
                <article class="columns small-12 medium-4 card--city">
                  <?php
                    include( locate_template( NT_COMPONENTS_PATH .'cards/card--city.php') );
                  ?>
                </article>
                <?php
              break;

            }
          }
          ?>
        </div>
      </section><!-- end of .post-entry -->
    </div><!-- end of content columns small-12-->

    <div class="content columns small-12">
      <header class="content--heading">
        <h2>Feature Guides</h2>
      </header>

      <div class="content-desc">
        <p>Whatever irony tacos gochujang mixtape, church-key crucifix shoreditch.</p>
      </div>

      <div class="content--post--home">
        <div class="row">
          <div class="columns small-12 medium-4 card--guides-featured">
            <?php
              include( locate_template( NT_COMPONENTS_PATH .'cards/card--guides-featured.php') );
            ?>
          </div>

          <div class="columns small-12 medium-4 card--guides-featured">
            <?php
              include( locate_template( NT_COMPONENTS_PATH .'cards/card--guides-featured.php') );
            ?>
          </div>

          <div class="columns small-12 medium-4 card--guides-featured">
            <?php
              include( locate_template( NT_COMPONENTS_PATH .'cards/card--guides-featured.php') );
            ?>
          </div>
        </div><!--end of row-->
      </div><!--end content--post-->
    </div><!-- end of content columns small-12-->
  </div><!--end of row-->

  <?php comments_template( '', true );

  endwhile;

else :

  echo 'no content';

endif; ?>

<?php get_footer(); ?>
