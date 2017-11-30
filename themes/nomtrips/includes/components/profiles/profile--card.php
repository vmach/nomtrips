<div class="profile--card">
  <div class="profile--avatar">
    <div class="image">
      <?php
        if (function_exists('get_avatar')) {
          echo get_avatar($email);
        } 

        else {
          //alternate gravatar code for < 2.5
          $grav_url = "http://www.gravatar.com/avatar/" . 
          md5(strtolower($email)) . "?d=" . urlencode($default) . "&s=" . $size;
          echo "<img src='$grav_url'/>";
        }
      ?>
    </div><!--/image-->
  </div><!--/profile--avatar-->
  
  <div class="profile--about">
    <div class="profile--name">
      <?php echo esc_html( $user->data->display_name ); ?>
    </div>
    
    <div class="profile--city">
      <p><?php echo esc_html( $user_city ); ?></p>
    </div>
    
    <div class="profile--desc">
      <p><?php echo esc_html( $user_desc ); ?></p>
    </div>
    
    <div class="social-icons--profile">
      <?php get_template_part(NT_COMPONENTS_PATH . 'social/social-icons', '-profile'); ?>
    </div>
    
    <div class="profile--edit-link">
      <a class="button" href="<?php echo esc_url( $user_link ); ?>">Edit Profile</a>
    </div>
  </div><!--/profile--about-->
</div><!--/profile--card-->