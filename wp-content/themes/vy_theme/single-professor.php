<?php
  
  get_header();

  while(have_posts()) {
    the_post(); 
    pageBanner();
    ?>
    

  <div class="container container--narrow page-section">
    <div class="generic-content">
      <div class='row group'>
        <div class='one-third'>
          <?php the_post_thumbnail('profosserPotrait')?>
        </div>
        <div class='two-thirds'>
          <?php 
          $likeCount = new WP_Query(array(
            'post_type' => 'like',
            'meta_query' => array(
              array(
                'key' => 'liked_professor_id',
                'compare' => '=',
                'value' => get_the_ID()
              )
            )
          ));

          $existStatus = 'no';

          if(is_user_logged_in()){
            // $existQuery = Id of that query
            $existQuery = new WP_Query(array(
              'author' => get_current_user_id(),
              'post_type' => 'like',
              'meta_query' => array(
                array(
                  'key' => 'liked_professor_id',
                  'compare' => '=',
                  'value' => get_the_ID()
                )
              )
            ));
  
          }
          
          if($existQuery->found_posts) $existStatus = 'yes';
          ?>
          <span class='like-box' data-like="<?php echo $existQuery->posts[0]->ID ?>" data-exists="<?php echo $existStatus;?>" data-professor='<?php the_ID(); ?>'>
            <i class='fa fa-heart-o' aria-hidden='true'></i>
            <i class='fa fa-heart' aria-hidden='true'></i>
            <span class='like-count'><?php echo $likeCount->found_posts;?></span>
          </span>
        <?php the_content()?>
        </div>
      </div>
    </div>
    <h4>Subject taught</h4>
    <ul class='link-list min-list'>
    <?php 
    $relatedPrograms = get_field('related_programs');
    // echo get_the_permalink($program) vi lay no ra tu field
    if($relatedPrograms){
      foreach($relatedPrograms as $program){
      ?>

      <li><a href="<?php echo get_the_permalink($program) ?>"><?php echo get_the_title($program) ;?></a></li>
      <?php }} ?>
      </ul>
    </div>
    
  <?php } ?>
<?php  get_footer(); ?>