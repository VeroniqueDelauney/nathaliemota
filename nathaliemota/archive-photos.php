<!-- Formulaire de filtre -->
<div class="filtres">
    <div>
        <select list name="categories" class="form_filter">
            <option>Catégories</option>
        </select>
        <select list name="formats" class="form_filter">
            <option>Formats</option>
        </select>
    </div>
    <div>
        <select list name="tri" class="form_filter">
            <option>Trier par</option>
        </select>
    </div>
</div>

<!-- Liste des photos -->
<div class="photos" id="picturesContainer">

    <?php 
    // Arguments de ce que l'on souhaite afficher
    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 4,
        'orderby' => 'date',
        'order' => 'DESC',
        'paged' => 1
    );

    // Exécution appel WP Query
    $photographs = new WP_Query( $args );

    $nbre_de_photos_total = $photographs->found_posts;

    // Boucle
    if( $photographs->have_posts() ) : while( $photographs->have_posts() ) : $photographs->the_post();

    // On appelle le template bloc_photo.php qui retourne une photo mise en page
    include('templates/photo_block.php');
    endwhile;
    endif;

    // Affichage de l'index de la photo en cours
    echo $photographs->current_post;
    //echo $nbre_de_photos_total; // => 16

    // Réinitialisation de la requête principale (important)
    wp_reset_postdata();
    ?>
</div>

<div class="center">
    <button class="btn btn-default" id="load-more-photos">
        Charger plus
    </button>
</center>



<!-- 
<h2>Il y a <?php comments_number(); ?></h2>

<?php if( get_comments_number() ): ?>

<?php endif; ?> -->