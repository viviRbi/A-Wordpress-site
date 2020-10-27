<?php 

// wordpress dash icon for menu icon
function insert_post_type(){
  register_post_type('event', array(
    // To give role to other member using Members Plugin (create by MemberPress)
    'capability_type' => 'event',
    'map_meta_cap' => true,
    //-----
    //Show in JSON route
    'show_in_rest' => true,
    //-----
    'posts_per_page' => 2,
    //In the edit page, show edit title, editor, except input. Open ech post, look to the right, allow comments
    'supports' => array('title','editor','excerpt', 'comments'),
    //--
    //Url turns to /events at archive-event
    'rewrite' => array('slug' => 'events'),
    //-- 
    'has_archive' => true,
    'public' => true,
    // Search wp dashicons
    'menu_icon' => 'dashicons-calendar',
    //---
    // Edit label name so it different from Post
    'labels' => array(
      'name' => 'Events',
      'add_new_item' => 'Add New Event',
      'edit_item' => 'Edit Event',
      'all_items' => 'All Events',
      'singular_name' => 'Event'
    )
  ));

  register_post_type('program', array(
    'show_in_rest' => true,
    'supports' => array('title','editor','excerpt'), // excerp de viet tin minh muon. o fai content nhung neu o co the thay dk content
    'rewrite' => array('slug' => 'programs'), 
    'has_archive' => true,
    'public' => true,
    'menu_icon' => 'dashicons-awards',
    'labels' => array(
      'name' => 'Programs',
      'add_new_item' => 'Add New Program',
      'edit_item' => 'Edit Program',
      'all_items' => 'All Programs',
      'singular_name' => 'Program'
    )
  ));

  register_post_type('professor', array(
    'show_in_rest' => true,
    'supports' => array('title','editor','thumbnail'),
    'public' => true,
    'menu_icon' => 'dashicons-welcome-learn-more',
    'labels' => array(
      'name' => 'Professors',
      'add_new_item' => 'Add New Professor',
      'edit_item' => 'Edit Professor',
      'all_items' => 'All Professors',
      'singular_name' => 'Professor'
    )
  ));

  register_post_type('note', array(
    // To give role to other member using Members Plugin (create by MemberPress)
    'capability_type' => 'note',
    'map_meta_cap' => true,
    //-----
    //Show in JSON route
    'show_in_rest' => false,
    //-----
    //In the edit page, show edit title, editor, except input. Open ech post, look to the right, allow comments
    'supports' => array('title','editor','excerpt', 'comments'),
    //--
    //Url turns to /events at archive-event
    'rewrite' => array('slug' => 'notes'),
    //-- 
    'has_archive' => true,
    'public' => true,
    // Search wp dashicons
    'menu_icon' => 'dashicons-welcome-write-blog',
    //---
    // Edit label name so it different from Post
    'labels' => array(
      'name' => 'Note',
      'add_new_item' => 'Add New Note',
      'edit_item' => 'Edit Note',
      'all_items' => 'All Notes',
      'singular_name' => 'Note'
    )
  ));
  register_post_type('like', array(
    'supports' => array('title'),
    'show_in_rest' => true,
    'public' => false,
    'show_ui' => true,
    'labels' =>array(
      'name' => 'Likes',
      'add_new_item' => 'Add New Like',
      'edit_item' => 'Edit Like',
      'all_items' => 'All Likes',
      'singular_name' => 'Like'
    ),
    'menu_icon' => 'dashicons-heart'
  ));
};

add_action( 'init', 'insert_post_type' );