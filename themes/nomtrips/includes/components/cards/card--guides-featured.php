<article class="card--guides-featured--item" href="#">
  <div class="card--guides-featured--image">
    <img src="<?php echo site_url(); ?>/wp-content/uploads/2016/09/feature_guide_placeholder.jpg" alt="Click to visit this guide" />

    <div class="card--guides-featured--profile">
      <div class="profile">
          <div class="profile--avatar">
            <div class="image">
              <img src="<?php echo site_url(); ?>/wp-content/uploads/2016/09/ron_swanson.jpg" />
            </div>
          </div>

          <div class="profile--name--white">
            Rob Swansan
          </div>
        </div>
    </div>
  </div>

  <header class="card--guides-featured--title">
    <h3 class="card--guides-featured--heading">Guide Title</h3>
  </header>

  <div class="card--guides-featured--content">
    <p>Selfies street art celiac, artisan actually pug photo booth drinking vinegar.</p>
    <?php
    if( (rand(0, 1)) )
      echo "<p>Organic ramps listicle, occupy meditation chia small batch freegan locavore bespoke.</p>";

    if( (rand(0, 1)) )
      echo "<p>Whatever irony tacos gochujang mixtape, church-key crucifix shoreditch. Tote bag tilde meditation heirloom church-key.</p>";
    ?>
  </div>

  <footer class="card--guides-featured--action">
    <a href="#">Read More</a>
  </footer>
</article>
