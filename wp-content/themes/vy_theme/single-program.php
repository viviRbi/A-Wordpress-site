<?php
  get_header();

  while(have_posts()) {
    the_post(); ?>
    <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg')?>);"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php the_title()?></h1>
      <div class="page-banner__intro">
        <p>Learn how the school of your dreams got started.</p>
      </div>
    </div>  
  </div>

  <div class="container container--narrow page-section">
    <div class='metabox metabox--position-up metabox--with-home-link'>
      <p>
        <a class='metabox__blog-home-link' href="<?php echo get_post_type_archive_link('program')?>">
          <i class="fa fa-home" aria-hidden="true"></i> Program Home
        </a> 
    </p>
    </div>
    <div class="generic-content"><?php the_content()?></div>
    <?php } ?>
    <h2><?php the_title() ?> Professors</h2>
    <?php 
        $today = date('Ymd');
        $professors = new WP_Query(array(
          'post_per_page' => -1,
          'post_type' => 'professor',
          'orderby' => 'title',
          'order' => 'ASC',
          'meta_query' => array(
            array(
               'key' => 'related_programs',
               'compare' => 'LIKE',
               'value' => '"' .get_the_ID() . '"'
            )
          )
        ));
    if($professors){
        echo '<ul class="professor-cards">';
        while($professors->have_posts()){
          $professors->the_post();
    ?>
       
        <li class='professor-card__list-item'>
            <a class='professor-card' href ="<?php the_permalink()?>"> 
                <img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLandscape')?>">
                <span class="professor-card__name"><?php the_title() ?></span>
            </a>
        </li>
    <?php 
        } echo '</ul>';
    } wp_reset_postdata(); 
    ?>

    <h2>Up coming <?php the_title() ?> Events</h2>
    <?php 
        $today = date('Ymd');
        $homepageEvents = new WP_Query(array(
          'post_type' => 'event',
          'meta_key' => 'event_date',
          'orderby' => 'meta_value_num',
          'order' => 'ASC',
          'meta_query' => array(
            array(
              'key' => 'event_date',
              'compare' => '>=',
              'value' => $today,
              'type' => 'numeric'
            ),
            array(
               'key' => 'related_programs',
               'compare' => 'LIKE',
               'value' => '"' .get_the_ID() . '"'
            )
          )
        ));
    if($homepageEvents){
        while($homepageEvents->have_posts()){
          $homepageEvents->the_post();
          get_template_part('template-part/event');
    }} wp_reset_postdata(); ?>
    </div>
       

<?php  get_footer(); ?>