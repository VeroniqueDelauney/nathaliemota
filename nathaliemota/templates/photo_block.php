<div class="photoTop">

    <?php 
    // Arguments de ce que l'on souhaite afficher
    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 1,
        'orderby' => 'rand'
    );

    // Exécution appel WP Query
    $my_query = new WP_Query( $args );

    // Boucle
    if( $my_query->have_posts() ) : while( $my_query->have_posts() ) : $my_query->the_post();
    ?>

    <!-- Affichage de la photo -->
    <img src="<?php the_field('Photo') ?>">

    <?php
    endwhile;
    endif;

    // Réinitialisation de la requête principale (important)
    wp_reset_postdata();
    ?>

    <div class="text">Photographe Event</div>

</div>