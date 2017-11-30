<!--slide-->
<li class="cards--carousel--slide">
  <div class="card--location" data-url="<?php the_permalink(); ?>">
    <div class="card--location--rating">
      <div class="indicator-likes--map">5</div>
    </div>
    <div class="card--location--title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
    <ul class="card--location--address">
      <li><?php echo esc_html( $restaurant->get_address_string() ); ?></li>
      <li class="card--restaurant--cuisine">
        <?php
        if( $restaurant->restaurant_cuisines->terms ) {
          $cuisine_urls = array();
          foreach( $restaurant->restaurant_cuisines->urls as $u) {
            $cuisine_urls[] = '<a href="' . esc_url( $u[1]) .'">' . esc_html( $u[0] ) . '</a>';
          }
          $cuisine_urls = implode( ',&nbsp;', $cuisine_urls );
          echo $cuisine_urls;
        }
        ?>
      </li>
      <li>
        <span class="card--location--icon-bar">
          <i class="fa fa-map-o"></i>
          <i class="fa fa-list-ul"></i>
        </span>
      </li>
    </ul>
  </div>
</li>
