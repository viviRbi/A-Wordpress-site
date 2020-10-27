<?php

function vyLikeRoute(){
    register_rest_route( 'vyTheme/v1', 'like', array(
        'methods' => WP_REST_Server::EDITABLE,
        'callback' => 'createLike'
    ));

    register_rest_route( 'vyTheme/v1', 'like', array(
        'methods' => WP_REST_Server::DELETABLE,
        'callback' => 'deleteLike'
    ));
};

function createLike($data){
    if(is_user_logged_in()){
        // Receive all data from ajax in like.js 
        // $data['professorId'] to get the professor ID
        $professor = sanitize_text_field($data['professorId']);

        // Find Like post of this user
        $existQuery = new WP_Query(array(
            'author' => get_current_user_id(),
            'post_type' => 'like',
            'meta_query' => array(
              array(
                'key' => 'liked_professor_id',
                'compare' => '=',
                'value' => $professor
              )
            )
          ));
          // insert like professorID post with title ABC to database, view in Admin panel
          // To have the id of the like professor, send data from like.js ajax
          if($existQuery->found_posts == 0 && get_post_type($professor)=='professor'){
            return wp_insert_post(array(
                'post_type' => 'like',
                'post_status' => 'publish',
                'post_title' => 'Abc',
                'meta_input' => array(
                    'liked_professor_id' => $professor
                )
            ));
          } else die('Invalid professorID');
        
    } else {
        die('Only users can like');
    }
};

function deleteLike($data){
    $likeId = sanitize_text_field($data['likeID']);

    if(get_current_user_id() == get_post_field('post_author', $likeId) && get_post_type($likeId) == 'like'){
        wp_delete_post($likeId,true);
    } else die('You do not have permission to delete that');
};

add_action('rest_api_init','vyLikeRoute');