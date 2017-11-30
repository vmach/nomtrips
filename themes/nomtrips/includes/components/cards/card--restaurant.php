<div class="card--restaurant">
  <div class="card--restaurant--map">
    <div id="map" class="map"></div>
  </div>
  <div class="card--restaurant--address">
    <span>
      <?php echo esc_html( $restaurant->get_address_string() ); ?>
    </span>
  </div>

  <div class="card--restaurant--phone">
    <?php echo esc_html( $restaurant->restaurant_contact_info->phone ) ?>
  </div>

  <div class="card--restaurant--price-category">
    <?php echo esc_html( $restaurant->restaurant_price->string ) ?>
  </div>

  <div class="card--restaurant--cuisine">
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
  </div>

  <div class="card--restaurant--hours"><span><?php echo wp_kses_post( $restaurant->restaurant_hours->html ); ?></span></div>

  <div class="button-bar margin-top">
    <a class="button-bar--btn font-size-lg-strict fa fa-globe"></a>
    <a class="button-bar--btn font-size-lg-strict fa fa-twitter"></a>
    <a class="button-bar--btn font-size-lg-strict fa fa-facebook-official"></a>
    <a class="button-bar--btn font-size-lg-strict fa fa-google-plus"></a>
    <a class="button-bar--btn font-size-lg-strict fa fa-instagram"></a>
  </div>
</div>
