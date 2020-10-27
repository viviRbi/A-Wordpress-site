<?php

function universityRegisterSearch(){
    register_rest_route( 'vyTheme/v1', 'search', array(
        'methods' => WP_REST_SERVER::READABLE,
        'callback' => 'universitySearchResults'
    ));
};

function universitySearchResults($data){
    $mainQuery = new WP_Query(array(
        'post_type' => array('post','page','event','program','professor'),
        's' => sanitize_text_field($data['term'])
    ));
    $results = array(
        'generalInfo' => array(),
        'professors' => array(),
        'events' => array(),
        'programs' => array(),
    );

    while($mainQuery->have_posts()){
        $mainQuery->the_post();
        if (get_post_type() == 'post' || get_post_type() == 'page'){
            array_push($results['generalInfo'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'type' => get_post_type(),
                'authorName' => get_the_author()
            ));
        };
        if (get_post_type() == 'professor'){
            array_push($results['professors'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink()
            ));
        };
        if (get_post_type() == 'event'){
            array_push($results['events'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'type' => get_post_type(),
                'authorName' => get_the_author()
            ));
        };
        if (get_post_type() == 'program'){
            array_push($results['programs'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'id' => get_the_id(),
                'type' => get_post_type(),
                'authorName' => get_the_author()
            ));
        };
    };

    if ($results['programs']){
        $programRelationshipMetaQuery = array('relation' => 'OR' );
    
        foreach($results['programs'] as $item){
            array_push($programRelationshipMetaQuery, array(
                'key' => 'related_programs',
                'compare' => 'LIKE',
                'value' => '"'. $item['id']. '"'
            ));
        };
        $programRelationshipQuery = new WP_Query(array(
            'post_type' => array('professor','event'),
            'meta_query' => array($programRelationshipMetaQuery)
        ));
    
        while($programRelationshipQuery->have_posts()){
            $programRelationshipQuery->the_post();
            if (get_post_type() == 'professor'){
                array_push($results['professors'], array(
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink()
                ));
                $results['professors'] = array_values(array_unique($results['professors'], SORT_REGULAR));
            };
            if (get_post_type() == 'event'){
                array_push($results['events'], array(
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'type' => get_post_type(),
                    'authorName' => get_the_author()
                ));
                $results['events'] = array_values(array_unique($results['events'], SORT_REGULAR));
            };
        };
    };

    return $results;
};

add_action('rest_api_init','universityRegisterSearch');