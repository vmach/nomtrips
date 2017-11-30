<?php $img_url = $current->get_city_image( $image_size ); ?>
<a class="card--city--container" href="<?php echo esc_url( $current->term_url ); ?>">
  <div class="card--city--image">
    <img src="<?php echo esc_url( $img_url[0] ); ?>" alt="Click to view <?php echo esc_attr( $current->name ); ?>" />
  </div>
  <header class="card--city--title">
    <h2><?php echo esc_html( $current->name ) ?></h2>
  </header>
</a>
