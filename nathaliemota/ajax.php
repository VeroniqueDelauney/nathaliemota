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
        "load_more",
        "search_picture",
    ])) {
        die("Cheater :)");
    }

	$_POST['function']($_POST['data']);
}

//$currentPage = 1;
function load_more($args): string {
    //$currentPage = $currentPage + 1; // Do currentPage + 1, because we want to load the next page
    //  print_r($args);
    //  die;

    // 1. On définit les arguments pour définir ce que l'on souhaite récupérer : photos qui sont après la page courante
    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 4,
        'paged' => $_POST['paged'], // Charge la page suivante
    );

    //console.log(page);
    // 2. On exécute la WP Query
    $my_query = new WP_Query( $args );   

	// $return = [
    //     'html' => '<p style="border:3px solid black">Hello world !</p>'
	// ];

    // 3. On lance la boucle
    if( $my_query->have_posts())
    {
        while( $my_query->have_posts() ) : $my_query->the_post();
            $imgPath = get_field("picture")["url"];
            //$theTitle = the_title();
            $return = "<div class='photo'><a href='' class='linkPhoto'><img src='$imgPath'></a></div>";
        endwhile;
    }
    else
    {
        $return = ''; // "response" will store the result
    } 
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