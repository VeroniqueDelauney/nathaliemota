<div class="photoTop">

    <?php 
    // 1. On définit les arguments pour définir ce que l'on souhaite récupérer
    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 1,
        'orderby' => 'rand'
    );

    // 2. On exécute la WP Query
    $my_query = new WP_Query( $args );

    // 3. On lance la boucle !
    if( $my_query->have_posts() ) : while( $my_query->have_posts() ) : $my_query->the_post();
    ?>

    <img src="<?php the_field('Photo') ?>">

    <?php
    // echo (the_title() ."<br>" . );
    endwhile;
    endif;

    // 4. On réinitialise à la requête principale (important)
    wp_reset_postdata();

    the_content(); // Contenu de la page
    ?>

    <div class="text">Photographe Event</div>
</div>
