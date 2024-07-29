<!-- Formulaire de filtre -->
<div class="filtres">
    <div>
        <select list name="categories" class="form_filter" aria-label="Catégories de photos">
            <option value="">Catégories</option>            
            <?php 
            menuSelectTerms('cats'); 
            ?>            
        </select>
    
        <select list name="formats" class="form_filter" aria-label="Formats de photos">
            <option value="">Formats</option>
            <?php 
            menuSelectTerms('formats'); 
            ?>  
        </select>
    </div>
    <div>
        <select list name="tri" class="form_filter" aria-label="Trier les photos par ordre chronologique">
            <option value="">Trier par</option>
            <option value="">--------------------------</option>
            <option value="desc">A partir des plus récentes</option>
            <option value="asc">A partir des plus anciennes</option>
        </select>
    </div>
</div>

<!-- Liste des photos -->
<div class="photos" id="picturesContainer">

    <?php 
    // Arguments de ce que l'on souhaite afficher
    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 8,
        'orderby' => 'date',
        'order' => 'DESC',
        'paged' => 1
    );    
    $photographs = new WP_Query( $args ); // Exécution appel WP Query

    $max_num_pages = $photographs->max_num_pages;

    $photo_position = 1;
    // Boucle
    if( $photographs->have_posts() ) : while( $photographs->have_posts() ) : $photographs->the_post();

    // Appel du template "bloc_photo.php" qui retourne une photo mise en page
    include('templates/photo_block.php');

    $photo_position ++;
    endwhile;
    endif; 

    // Réinitialisation de la requête principale
    wp_reset_postdata();
    ?>
</div>

<!-- On passe le nombre de pages maxi -->
<input type="hidden" name="maxNbOfPages" value="<?php echo $max_num_pages ?>">

<div class="center" id="LoadMore">
    <button class="btn btn-default" id="load-more-photos" title="Charger plus de photos">
        Charger plus
    </button>
</div>

<div class="lightbox">
    <div class="lightbox_prev" title="Photo précédente"></div>
    <div class="lightbox_center">
        <div class="photo">
            <img src="" class="jpeg" alt="">
        </div>
        <div class="lightbox_info">
            <div class="col1">
                <!-- REFERENCE DE LA PHOTO -->
            </div>
            <div class="col2">
                <!-- CATEGORIE -->
            </div>
        </div>
    </div>
    <div class="lightbox_next" title="Photo suivante"></div>
    <div class="lightbox_close" alt="Fermer"></div>
</div>