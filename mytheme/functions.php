<?php

    add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
    function theme_enqueue_styles() {
        wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' ); // get_template_directory_uri => thème parent
        wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/assets/css/theme.css' ); // get_stylesheet_directory_uri => thème enfant
        wp_enqueue_script( 'app-script', get_stylesheet_directory_uri() . '/assets/js/app.js');
    }

    // $path = '/js/app.js';
   
    // Get customizer options form parent theme
    if ( get_stylesheet() !== get_template() ) {
        add_filter( 'pre_update_option_theme_mods_' . get_stylesheet(), function ( $value, $old_value ) {
            update_option( 'theme_mods_' . get_template(), $value );
            return $old_value; // prevent update to child theme mods
        }, 10, 2 );
        add_filter( 'pre_option_theme_mods_' . get_stylesheet(), function ( $default ) {
            return get_option( 'theme_mods_' . get_template(), $default );
        } );
    }

    $path = '/js/app.js';

    // Create new top menu -- VD
    function register_top_menu() {
        register_nav_menu('top-menu',__( 'Top menu' ));
    }
    add_action( 'init', 'register_top_menu' );


    // Create new footer menu -- VD
    function register_footer_menu() {
        register_nav_menu('footer-menu',__( 'Footer menu' ));
    }
    add_action( 'init', 'register_footer_menu' );






    // Edit main top menu
    add_filter( 'wp_nav_menu_items', 'add_extra_item_to_nav_menu', 10, 2);
    function add_extra_item_to_nav_menu( $items, $args ) {   
        
        if(!is_super_admin()) return $items; // On retourne les éléments du menu si le visiteur n'est pas Admin

        if($args->menu->term_id != 4) return $items; // On retourne les éléments du menu si on est dans un menu qui n'est pas le menu du haut (le menu 7)

        $ex = explode("<li" , $items); // On éclate le tableau pour séparer chaque <li>"

        $last_li = $ex[sizeof($ex)-1]; // On définit le dernier <li> en récupérant le dernier <li> et en enlevant 1

        $last_li = "<li".$last_li; // on met en forme le dernier <li> en lui rajoutant la balise <li> ouvrante

        $admin_link = '<li class="menu-item" id="myBtn"><a>CONTACT</a></li>'; // On prépare le contenu du lien d'admin

        $items = str_replace($last_li , $admin_link, $items); // On remplace le dernier <li> par deux nouveaux <li> => le <li> de l'admin et le <li> qui était déjà le dernier

        return($items); // On retourne le menu complet
        
    }
    
?>