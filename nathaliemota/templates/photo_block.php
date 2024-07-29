<!-- Affichage de la photo -->
<div class="photo">

    <?php
        $terms = get_terms_of_posts(get_the_ID(), 'cats');
    ?>

    <!-- Icône de lightbox et passage des paramètres/filtres -->
    <div class="enlarge zoom">
        <img src="<?php echo get_template_directory_uri() . '/assets/img/expand-icon.svg'; ?>" class="linkPhoto" alt="Voir la photo en plein écran"
            data-category="<?php echo implode(" , ", $terms); ?>"
            data-position="<?php echo $photo_position; ?>" 
            data-image="<?php echo get_field("picture")["url"]; ?>" 
            data-reference="<?php echo get_field("reference"); ?>" 
            data-title="<?php the_title(); ?>"
        />        
    </div>

    <!-- Affichage de la photo -->
    <a href="<?php echo get_field("picture")["url"]; ?>" title="Voir la photo '<?php the_title(); ?>'">
        <img src="<?php echo get_field("picture")["sizes"]["large"]; ?>" alt="<?php the_title(); ?>">
    </a>	

    <!-- Affichage de l'icône oeil -->
    <a href="<?php the_permalink(); ?>" title="Voir la photo '<?php the_title(); ?>'">
        <img src="<?php echo get_template_directory_uri() . '/assets/img/eye-3-64.png'; ?>" class="eye" alt="Voir la photo">
        <!-- Informations affichées sous chaque photo -->
        <div class="info">
            <div><?php the_title(); ?></div>
            <div>
                <?php 
                    // Utilisation de 'Implode' pour retourner une chaine de caractères séparés par des virgules      
                    echo implode(", ", $terms);               
                ?>               
            </div>
        </div>
    </a>
</div>