<?php 
require get_theme_file_path('include/like-route.php');
require get_theme_file_path('include/search-route.php');
?>
<?php
// So that it appeared in Json to use in Js
function university_rest_api(){
  register_rest_field('post','authorName',array(
    'get_callback' => function(){return get_the_author();}
  ));

  register_rest_field('note','userNoteCount',array(
    'get_callback' => function(){return count_user_posts(get_current_user_id(),'note');}
  ));
}
add_action('rest_api_init','university_rest_api');
?>
<?php function pageBanner(){ ?>
<div class="page-banner">
    <div class="page-banner__bg-image" 
    style="background-image: url(<?php echo get_field('page_banner_background_image')?get_field('page_banner_background_image')['sizes']['pageBanner']:get_theme_file_uri('/images/ocean.jpg')?>);"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php the_title()?></h1>
      <div class="page-banner__intro">
        <p><?php the_field('page_banner_subtitle')?></p>
      </div>
    </div>  
  </div>
<?php }

function university_files() {
  wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
  wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');

  if(strstr($_SERVER['SERVER_NAME'],'localhost')){
    wp_enqueue_script( 'main-university-js', 'http://localhost:3000/bundled.js', NULL, '1.0', true);
  }else{
    wp_enqueue_script( 'our-vendor-js', get_theme_file_uri('/bundled-assets/vendors~scripts.9678b4003190d41dd438.js'), NULL, '1.0', true);
    wp_enqueue_script( 'main-university-js', get_theme_file_uri('/bundled-assets/scripts.f68cdeed9c2375174e3f.js'), NULL, '1.0', true);
    wp_enqueue_style( 'university_main_styles', get_theme_file_uri('/bundled-assets/styles.f68cdeed9c2375174e3f.css'));
  }

  wp_localize_script('main-university-js', 'vyThemeData', array(
    'root_url' => get_site_url(),
    'nonce' => wp_create_nonce('wp_rest')
  ));
};

add_action('wp_enqueue_scripts', 'university_files');

function university_feature(){
  register_nav_menu('headerMenu','Header Menu Location');
  register_nav_menu('footerLocationOne', 'Footer Location One');
  register_nav_menu('footerLocationTwo', 'Footer Location Two');
  add_theme_support('title-tag'); // add head title tag on webpage
  add_theme_support('post-thumbnails');
  // Add plugin 'Regenerate Thumbnail' for all prev thumbnail image
  add_image_size('professorLandscape',400, 260, true);
  add_image_size('profosserPotrait', 480,650, true); // true = shouldn't be crop
  add_image_size('pageBanner',1500, 350, true);
}

add_action('after_setup_theme', 'university_feature');

// Before post, put them in an order 
function university_adjust_query($query){
  if(!is_admin() && is_post_type_archive('program') && $query->is_main_query()){
    $query->set('orderby','title');
    $query->set('order','ASC');
    $query->set('posts_per_page',-1);
  }
  if(!is_admin() && is_post_type_archive('event') && $query->is_main_query()){
    $today = date('Ymd');
    $query->set('meta_key','event_date');
    $query->set('orderby','meta_value_num');
    $query->set('order', 'ASC');
    $query->set('meta_query', array(
      array(
        'key' => 'event_date',
        'compare' => '>=',
        'value' => $today,
        'type' => 'numeric'
      )
    ));
    //$query->set('posts_per_page',2); this attr does not exist https://developer.wordpress.org/reference/functions/register_post_type/
  }
};
add_action('pre_get_post', 'university_adjust_query');

// Redirect subscriber accounts from dashboard to homepage(frontend.php)
function redirectSubToFrontEnd(){
  $currentUser = wp_get_current_user();
  if(count($currentUser->roles)==1 AND $currentUser->roles[0]=='subscriber'){
    wp_redirect(site_url('/'));
    exit;
  }
}
add_action('admin_init', 'redirectSubToFrontEnd');

// No admin bar for subscriber
function noSubsAdminBar(){
  $currentUser = wp_get_current_user();
  if(count($currentUser->roles)==1 AND $currentUser->roles[0]=='subscriber'){
    show_admin_bar(false);
  }
}
add_action('wp_loaded','noSubsAdminBar');

// Customize Login Screen
function ourHeaderUrl(){
  return esc_url(site_url('/'));
}
add_filter('login_headerurl','ourHeaderUrl');

function ourLoginCSS(){
  wp_enqueue_style( 'university_main_styles', get_theme_file_uri('/bundled-assets/styles.f68cdeed9c2375174e3f.css'));
}
add_action('login_enqueue_scripts','ourLoginCSS');

function ourLoginTitle(){
  return get_bloginfo('name');
}
add_action('login_headertitle','ourLoginTitle');

// Force note posts to be private so user can't go to REST API route
function makeNotePrivate($data, $postarr){
  if($data['post_type']== 'note'){
    if(count_user_posts(get_current_user_id(), 'note') > 5 AND !$postarr['ID']){
      die('You have reached your limit. Delete some note to create a new one');
    }
    $data['post_content'] = sanitize_textarea_field($data['post_content']);
    $data['post_title'] = sanitize_text_field($data['post_title']);
  }
  if($data['post_type']== 'note' AND $data['post_status']!='trash'){
    $data['post_status'] = 'private';
  }
  return $data;
}
add_filter('wp_insert_post_data', 'makeNotePrivate', 10, 2);
?>