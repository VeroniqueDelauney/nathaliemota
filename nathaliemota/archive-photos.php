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
        'posts_per_page' => 4,
        'orderby' => 'date',
        'order' => 'DESC',
        'paged' => 1
    );

    // Exécution appel WP Query
    $photographs = new WP_Query( $args );

    // Boucle
    if( $photographs->have_posts() ) : while( $photographs->have_posts() ) : $photographs->the_post();
    ?>

    <!-- Affichage de la photo -->
    <div class="photo">

        <!-- Lien vers la lightbox -->
		<div class="enlarge">
			<a href="<?php echo get_field("picture")["url"]; ?>">
				<img src="<?php echo get_template_directory_uri() . '/assets/img/expand-icon.svg'; ?>">
			</a>	
		</div>

        <!-- Affichage de la photo -->
		<a href="<?php echo get_field("picture")["url"]; ?>" title="Voir la photo '<?php the_title(); ?>'" class="linkPhoto">
			<img src="<?php echo get_field("picture")["url"]; ?>">
		</a>	

        <!-- Affichage de l'icône oeil -->
		<a href="<?php the_permalink(); ?>" title="Voir la photo '<?php the_title(); ?>'">
			<img src="<?php echo get_template_directory_uri() . '/assets/img/eye-3-64.png'; ?>" class="eye">
		</a>

        <!-- Infos sur le bas de chaque photo -->
		<a href="<?php echo get_field("picture")["url"]; ?>" title="Voir la photo '<?php the_title(); ?>'" class="linkPhoto">
			<div class="info">
				<div><?php the_title(); ?></div>
				<div>
                    <?php 
                        $terms = get_terms_of_posts(get_the_ID(), 'cats');
                        echo implode(" , ", $terms); // 'Implode' retourne une chaine de caractères séparés par des virgules
                    ?>
                </div>
			</div>
		</a>
    </div>    

    <?php
    endwhile;
    endif;

    // Réinitialisation de la requête principale (important)
    wp_reset_postdata();
    ?>

    <!-- Affichage des photos suivantes -->
    <div class="photosNew">        
    </div>

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