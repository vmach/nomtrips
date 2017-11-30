<nav role="navigation" class="nav--logged-in">
  <?php
    $email = $user->data->user_email;
  ?>
  <div class="profile--header">
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
      </div>
    </div>

    <div class="profile--name">
      <?php echo $user->data->display_name; ?>
    </div>
  </div>
  <ul class="menu--logged-in-items">
    <li><a href="my-itineraries/">Your Itineraries</a></li>
    <li><a href="#">Nom Lists</a></li>
    <li><a href="#">Saved Guides</a></li>
    <li><a href="<?php echo wp_logout_url(home_url( '/' )) ?>">Logout</a></li>
  </ul>
</nav>

<?php
//search cities if not home page
if(!is_front_page())
  get_template_part(NT_COMPONENTS_PATH . 'forms/search', '-off-canvas-menu');
?>