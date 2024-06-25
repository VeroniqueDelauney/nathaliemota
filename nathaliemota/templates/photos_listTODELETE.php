<!-- Formulaire de filtre -->
<div class="filtres">
    <div>
        <select list name="categories">
            <option>Catégories</option>            
        </select>
        <select list name="formats">
            <option>Formats</option>
        </select>
    </div>
    <div>
        <select list name="tri">
            <option>Trier par</option>
        </select>
    </div>
</div>


<!-- Liste des photos -->
<div class="photos">

    <?php 
    // Arguments de ce que l'on souhaite afficher
    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 8
    );

    // Exécution appel WP Query
    $my_query = new WP_Query( $args );

    // Boucle
    if( $my_query->have_posts() ) : while( $my_query->have_posts() ) : $my_query->the_post();
    ?>

    <!-- Affichage de la photo -->
    <div class="photo">
        <a href="" title="Voir la photo">
            <img src="<?php the_field('Photo') ?>">
        </a>
    </div>    

    <?php
    endwhile;
    endif;

    // Réinitialisation de la requête principale (important)
    wp_reset_postdata();
    ?>

</div>


<div class="center">
    <!-- CTA "Charger plus" -->
    <div class="btn btn-default">
        Charger plus
    </div>
</div>