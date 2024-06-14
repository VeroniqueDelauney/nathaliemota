<?php

/**
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

function load_more($args): string {
    // print_r($args);
    // die;
    // Récupérer les photos avec wp_query suivant page courante
    // Parcourir ces photos et créer le code html correspondant
    // Retourner ce code html ligne 33
    // Dans le javascript, injecter ce code html dans la page
	$return = [
        
        'html' => '<p style="border:3px solid black">Hello world !</p>'
	];

    wp_send_json($return);
    //wp_send_json_success( $return );

}

// <?php
// add_action( 'wp_ajax_capitaine_load_comments', 'capitaine_load_comments' );
// add_action( 'wp_ajax_nopriv_capitaine_load_comments', 'capitaine_load_comments' );

// function capitaine_load_comments() {
  

//     // On vérifie que l'identifiant a bien été envoyé
//     if( ! isset( $_POST['postid'] ) ) {
//     	wp_send_json_error( "L'identifiant de l'article est manquant.", 400 );
//   	}

//   	// Récupération des données du formulaire
//   	$post_id = intval( $_POST['postid'] );

//   	// Utilisez sanitize_text_field() pour les chaines de caractères.
//   	// exemple : 
//     $name = sanitize_text_field( $_POST['name'] );

//   	// Requête des commentaires
//   	$comments = get_comments([
//     	'post_id' => $post_id,
//     	'status' => 'approve'
//   	]);

//   	// Préparer le HTML des commentaires
//   	$html = wp_list_comments([
//     	'per_page' => -1,
//     	'avatar_size' => 76,
//     	'echo' => false,
//   	], $comments );

//   	// Envoyer les données au navigateur
// 	wp_send_json_success( $html );
// }
























































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

