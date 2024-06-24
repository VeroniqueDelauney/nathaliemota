<?php
/*
 * Allow to call any php function or method.
 */
add_action('wp_ajax_nathaliemota', 'nathaliemota_ajax_router');
add_action('wp_ajax_nopriv_nathaliemota', 'nathaliemota_ajax_router');

function nathaliemota_ajax_router(): string
{	
    // Vérification de sécurité
    if (!in_array($_POST['function'], [
        "search_picture",
    ])) {
        die("Cheater :)");
    }

	$_POST['function']($_POST['data']);
}

//$currentPage = 1;
function search_picture($args): string {
    $return = [
        "html_content"=>"",
        "has_more_pictures"=>1
    ];
    $args = parse_str($args, $params);

    // 1. On définit les arguments pour définir ce que l'on souhaite récupérer : photos qui sont après la page courante
    $query_args = array(
        'post_type' => 'photos',
        'posts_per_page' => 4,
        'paged' => $params['page'], // Charge la page suivante
    );

    // 2. On exécute la WP Query
    $my_query = new WP_Query( $query_args );   

    // 3. On lance la boucle
    ob_start(); // Output buffer
    if( $my_query->have_posts())
    {
        while( $my_query->have_posts() ) : $my_query->the_post();
             include(THEME_DIR . '/templates/photo_block.php');
         endwhile;
    }
    $return["html_content"] = ob_get_contents(); // Tout ce qui aurait dû être affiché est mis dans $return
    ob_end_clean();
    ob_end_flush(); // Remet le buffer à 0
    wp_send_json($return);
    
    // 4. On réinitialise à la requête principale pour que le reste de la page fonctionne correctement
    wp_reset_postdata();  
    exit;
}






// Call one photograph for home page hero
function nathaliemota_request_heroPhoto() {
    $args = array( 'post_type' => 'photos', 'posts_per_page' => 1 );
    $query = new WP_Query($args);
    if($query->have_posts()) {
        $response = $query;
    } else {
        $response = false;
    }    
    wp_send_json($response);
    wp_die();
}
add_action( 'wp_ajax_request_recettes', 'nathaliemota_request_heroPhoto' );
add_action( 'wp_ajax_nopriv_request_recettes', 'nathaliemota_request_heroPhoto' );