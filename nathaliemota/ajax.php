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


// $currentPage = 1;
function search_picture($args): string {
    $json_returned = [
        "html_content"=>"",
        "has_more_pictures"=>1
    ];
    $args = parse_str($args, $params); // Convertit la chaine args (qui contient les valeurs de category, format, etc depuis le JS) en tableau $params 

    // 1. On définit les arguments pour déclarer ce que l'on souhaite récupérer (=> photos qui sont après la page courante)
    // Requête par défaut pour tous les filtres
    $query_args = array(
        'post_type' => 'photos',
        'posts_per_page' => 8,
        'tax_query' => [],
        'orderby' => "date",
        'order' => "desc",
        'paged' => 1
    );

    if(!empty($params['category'])) { // $params['category'] est envoyé par le javascript -- "category" est le nom de la variable créée sur le js
        
        $query_args['tax_query'][] = array(
            'taxonomy' => 'cats',
            'terms' => $params['category'],
            'field' => 'slug',
            'operator' => 'IN',                
        );   
    }

    if(!empty($params['format'])) { // $params['format'] est envoyé par le javascript -- "format" est le nom de la variable créée sur le js
        $query_args["tax_query"][] = array(
            'taxonomy' => 'formats',
            'terms' => $params['format'],
            'field' => 'slug',
            'operator' => 'IN',                
        );        
    }

    // On récupère le sort asc ou desc pour l'ordre d'affichage
    if(!empty($params['sort'])) { // $params['sort'] est envoyé par le javascript -- "sort" est le nom de la variable créée sur le js
        $query_args["order"] = $params['sort'];        
    }

    if(!empty($params['page'])){
        $query_args["paged"] = $params['page'];
    }


    // 2. On exécute la WP Query
    $my_query = new WP_Query( $query_args );   

    $max_page = $my_query->max_num_pages;

    // On a atteint la dernière page
    if($max_page == $params["page"] || !$my_query->have_posts()) {
        $json_returned["has_more_pictures"] = 0;        
    }   


    // 3. On lance la boucle
    ob_start(); // Output buffer
    if( $my_query->have_posts())
    {
        $photo_position = ($params['page']-1)*8; // Gestion de l'affichage de 8 photos par page
        $photo_position ++; // Incrémentation de la position (ex : en page 2, on commence à la 9ème position)
        while( $my_query->have_posts() ) : $my_query->the_post();
             include(THEME_DIR . '/templates/photo_block.php');
             $photo_position ++;
         endwhile;
    }
    $json_returned["html_content"] = ob_get_contents(); // Tout ce qui aurait dû être affiché est mis dans $return
    ob_end_clean();
    ob_end_flush(); // Remet le buffer à 0
    wp_send_json($json_returned);
    
    // 4. On réinitialise à la requête principale pour que le reste de la page fonctionne correctement
    wp_reset_postdata();  
    exit;
}






// Sélection d'une photo pour la bannière du hero
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