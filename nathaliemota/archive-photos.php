<!-- Formulaire de filtre -->
<div class="filtres">
    <div>
        <select list name="categories" class="form_filter">
            <option>Catégories</option>            
            <?php 
            menuSelectTerms('cats'); 
            ?>            
        </select>
    
        <select list name="formats" class="form_filter">
            <option>Formats</option>
            <?php 
            menuSelectTerms('formats'); 
            ?>  
        </select>
    </div>
    <div>
        <select list name="tri" class="form_filter">
            <option>Trier par</option>
            <option>--------------------------</option>
            <option>Photos récentes</option>
            <option>Photos anciennes</option>
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

    //$nbre_de_photos_total = $photographs->found_posts;
    //$compteur = 0;

    // Boucle
    if( $photographs->have_posts() ) : while( $photographs->have_posts() ) : $photographs->the_post();

    // On appelle le template bloc_photo.php qui retourne une photo mise en page
    include('templates/photo_block.php');
    //$compteur ++;
    
    //echo $photographs->post_count; // Retourne 4
    //echo $nbre_de_photos_total; // => 16

    endwhile;
    endif; 
    
    // if($compteur < $nbre_de_photos_total) {
    //     echo "<div class='center'><button class='btn btn-default' id='load-more-photos'>Charger plus</button></div>";
    // }

    // Réinitialisation de la requête principale (important)
    wp_reset_postdata();

    ?>
</div>

<div class="center" id="LoadMore">
    <button class="btn btn-default" id="load-more-photos">
        Charger plus
    </button>
</center>



<!-- 
<h2>Il y a <?php comments_number(); ?></h2>

<?php if( get_comments_number() ): ?>

<?php endif; ?> -->