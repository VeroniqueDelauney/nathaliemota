<!-- Affichage de la photo -->
<div class="photo">

    <?php
        $terms = get_terms_of_posts(get_the_ID(), 'cats');
    ?>

    <div class="enlarge">
        <img src="<?php echo get_template_directory_uri() . '/assets/img/expand-icon.svg'; ?>" class="linkPhoto" 
            data-category="<?php echo implode(" , ", $terms); ?>"
            data-position="<?php echo $photo_position; ?>" 
            data-image="<?php echo get_field("picture")["url"]; ?>" 
            data-reference="<?php echo get_field("reference"); ?>" 
            data-title="<?php the_title(); ?>"
        />        
    </div>

    <!-- Affichage de la photo -->
    <a href="<?php echo get_field("picture")["url"]; ?>" title="Voir la photo '<?php the_title(); ?>'" class="zoom">
        <img src="<?php echo get_field("picture")["url"]; ?>">
    </a>	

    <!-- Affichage de l'icône oeil -->
    <a href="<?php the_permalink(); ?>" title="Voir la photo '<?php the_title(); ?>'">
        <img src="<?php echo get_template_directory_uri() . '/assets/img/eye-3-64.png'; ?>" class="eye">

        <!-- Infos sur le bas de chaque photo -->
        <div class="info">
            <div><?php the_title(); ?></div>
            <div>
                <?php 
                    echo implode(" , ", $terms); // 'Implode' retourne une chaine de caractères séparés par des virgules                    
                ?>               
            </div>
        </div>
    </a>
</div>


<!-- <div class="lightbox">
    <button class="lightbox_close">Fermer</button>
    <button class="lightbox_next">Suivante</button>
    <button class="lightbox_prev">Précédente</button>
    <div class="lightbox_container">
        <div>
            <img src="https://picsum.photos/900/1800">
        </div>
        <div class="info">
            <div><?php the_title(); ?></div>
            <div>
                <?php 
                    $terms = get_terms_of_posts(get_the_ID(), 'cats');
                    echo implode(" , ", $terms); // 'Implode' retourne une chaine de caractères séparés par des virgules
                ?>
            </div>
        </div>
    </div>
</div> -->