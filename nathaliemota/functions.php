<?php

// Theme paths
define('THEME_URI', get_template_directory_uri()); // url vers le thème 
define('THEME_DIR', get_template_directory()); // Chemin absolu


// On définit la version du thème
$assets_version = wp_get_theme()['Version']; // Récupère les infos du fichier style.css
define('ASSETS_VERSION', $assets_version);
include "ajax.php";
//include "test-ajax.php";


add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' ); // Ajoute les scripts et les styles
function theme_enqueue_styles() {
    wp_enqueue_style( 'main-style', THEME_URI . '/assets/css/theme.css', [], ASSETS_VERSION ); // get_stylesheet_directory_uri => thème enfant
    wp_enqueue_script( 'app-script', THEME_URI . '/assets/js/app_js.js', ["jquery"], ASSETS_VERSION ); // get script qui est dépendant de jquery
    wp_localize_script('app-script', 'theme_data', [ // Pour passer les variables directement au javascript
		'ajaxurl' 					=> admin_url( 'admin-ajax.php' ),		
		'is_logged_in'				=> (is_user_logged_in())
	]);
}

add_action( 'after_setup_theme', 'theme_functions' );
function theme_functions() {

    add_theme_support( 'title-tag' );

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
        'show_in_rest' => true, // Affichage de la taxonomie dans Gutemberg
        'rewrite' => array( 'slug' => 'cats' ),
        );
    register_taxonomy( 'cats', 'photos', $args ); // Ajout de la nouvelle taxonomie au nouveau CPT "Photo"

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
        'show_in_rest' => true, // Affichage de la taxonomie dans Gutemberg
        'rewrite' => array( 'slug' => 'formats' ),
        );
    register_taxonomy( 'formats', 'photos', $args ); // Ajout de la nouvelle taxonomie au nouveau CPT "Photo"
}
add_action( 'init', 'nathaliemota_register_post_types' ); // "Init" est un hook qui lance la fonction





// Retourne les termes d'une taxonomie non-associée à un post_id => Menu déroulants page d'accueil
function menuSelectTerms($taxo_slug) {
    $terms = get_terms( array(
        'taxonomy' => $taxo_slug,
        'hide_empty' => true
    ));        
    if ( !empty($terms) ) {
        echo '<option>--------------------------</option>';
        foreach ( $terms as $term ) {
            echo '<option value=' . $term->slug .'>' . $term->name . '</option>';
        }
    }
}


// Retourne un tableau des termes d'une taxo 'taxo_slug' associés à un post 'post_id'
function get_terms_of_posts($post_id, $taxo_slug) {
    $retour = [];
    $terms = get_the_terms($post_id, $taxo_slug);
    foreach($terms as $term) {
        $retour[] = $term->name;
    }
    return $retour;
}