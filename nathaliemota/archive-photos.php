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
		<div class="enlarge">
			<a href="<?php the_field('Photo') ?>">
				<img src="<?php echo get_template_directory_uri() . '/assets/img/expand-icon.svg'; ?>">
			</a>	
		</div>
		<a href="<?php the_permalink(); ?>" title="Voir la photo '<?php the_title(); ?>'">
			<img src="<?php echo get_field("picture")["url"]; ?>">
		</a>	
		<!-- <a href="<?php the_permalink(); ?>" title="Voir la photo '<?php the_title(); ?>'">
			<img src="<?php echo get_template_directory_uri() . '/assets/img/eye-3-64.png'; ?>" class="eye">
		</a>	 -->

		<!-- <a href="<?php the_permalink(); ?>" title="Voir la photo '<?php the_title(); ?>'">
			<div class="info">
				<div><?php the_title(); ?></div>
				<div><?php the_terms( get_the_ID(), 'cats' ); ?></div>
			</div>
		</a> -->
    </div>    

    <?php
    endwhile;
    endif;

    // Réinitialisation de la requête principale (important)
    wp_reset_postdata();
    ?>

</div>


<div class="center">
	<button class="btn btn-default" id="load-more-photos">
		Charger plus
	</button>

    <div class="photos" style="border:5px solid lime">
        <!-- Affichage des photos suivantes -->
	</div>
    
</div>






<!-- 
<h2>Il y a <?php comments_number(); ?></h2>

<?php if( get_comments_number() ): ?>

<?php endif; ?> -->



<!-- Lightbox -->
<!-- <div class="lightbox">
	<button class="lightbox_close">X</button>
	<button class="lightbox_next">Suivante</button>
	<button class="lightbox_prev">Précédente</button>
	<div class="lightbox_container">
		<img src="http://nathaliemota.local/wp-content/uploads/2024/06/nathalie-13-scaled.jpeg">
	</div>
</div> -->