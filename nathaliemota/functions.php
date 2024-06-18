<?php

// On définit la version du thème
$assets_version = wp_get_theme()['Version'];
define('ASSETS_VERSION', $assets_version);
include "ajax.php";


add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'main-style', get_stylesheet_directory_uri() . '/assets/css/theme.css', [], ASSETS_VERSION ); // get_stylesheet_directory_uri => thème enfant
    wp_enqueue_script( 'app-script', get_stylesheet_directory_uri() . '/assets/js/app_js.js', ["jquery"], ASSETS_VERSION );
    wp_localize_script('app-script', 'theme_data', [
		'ajaxurl' 					=> admin_url( 'admin-ajax.php' ),		
		"is_logged_in"				=> (is_user_logged_in())
	]);
}

// Create new menu zones -- VD
function register_menus() {
    register_nav_menu('top-menu',__( 'Top menu' ));
    register_nav_menu('footer-menu',__( 'Footer menu' ));
}
add_action( 'init', 'register_menus' );







function nathaliemota_register_post_types() {	
    // CPT Portfolio
    $labels = array(
        'name' => 'Photos',
        'all_items' => 'Toutes les photos',  // affiché dans le sous menu
        'singular_name' => 'Photo',
        'add_new_item' => 'Ajouter une photo',
        'edit_item' => 'Modifier la photo',
        'view_item' => 'Voir la photo',
        'search_items' => 'Rechercher des photos',
        'menu_name' => 'Photos',
        'not_found' => 'Aucune photo trouvée',
        'not_found_in_trash' => 'Aucune photo trouvée dans la corbeille'
    );
	$args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'show_ui' => true,
        'supports' => array('title', 'thumbnail'),
        // 'supports' => array( 'title', 'editor','thumbnail' ),
        'menu_position' => 5, 
        'menu_icon' => 'dashicons-camera',
        'meta_key' => 'Photo', // nom du champ personnalisé
	);
	register_post_type( 'photos', $args );



    // Déclaration de la taxonomie "Catégorie"
    $labels = array(
        'name' => 'Catégories',
        'singular_name' => 'Catégorie',
        'add_new_item' => 'Ajouter une catégorie',
        'edit_item' => 'Modifier la catégorie',
    );    
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
        'show_in_rest' => true, // This shows the taxonomy in Gutemberg
        'rewrite' => array( 'slug' => 'cats' ),
        );
    register_taxonomy( 'cats', 'photos', $args ); // Add the new taxonomy to the newly created "photos" CTP

    // Déclaration de la taxonomie "Format"
    $labels = array(
        'name' => 'Formats',
        'singular_name' => 'Format',
        'add_new_item' => 'Ajouter un format',
        'edit_item' => 'Modifier le format',
    );    
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
        'show_in_rest' => true, // This shows the taxonomy in Gutemberg
        'rewrite' => array( 'slug' => 'formats' ),
        );
    register_taxonomy( 'formats', 'photos', $args ); // Add the new taxonomy to the newly created "photos" CTP
}
add_action( 'init', 'nathaliemota_register_post_types' ); // Le hook init lance la fonction







// Retourne un tableau des termes d'une taxo 'taxo_slug' associés à un post 'post_id'
function get_terms_of_posts($post_id, $taxo_slug) {
    $retour = [];
    $terms = get_the_terms($post_id, $taxo_slug);
    foreach($terms as $term) {
        $retour[] = $term->name;
    }
    return $retour;
}