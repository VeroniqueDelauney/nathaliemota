<?php get_header(); ?>
<div class="main single">
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>


<div class="post">
    <!-- Col 1 -->
    <div class="col">
        <h1 class="post-title"><?php the_title(); ?></h1>
        <p>
            Référence : <?php echo(get_field("reference")); ?>
        </p>
        <p>
            Catégorie : 
            <?php 
            $terms = get_terms_of_posts(get_the_ID(), 'cats');
            echo implode(" , ", $terms); // 'Implode' retourne une chaine de caractères séparés par des virgules
            ?>
        </p>
        <p>
            Format : 
            <?php 
            $terms = get_terms_of_posts(get_the_ID(), 'formats');
            echo implode(" , ", $terms); // 'Implode' retourne une chaine de caractères séparés par des virgules
            ?>
        </p>
        <p>
            Type : <?php echo get_field("type"); ?>
        </p>
        <p>
            Année : <?php echo get_field("year"); ?>
        </p>
    </div>

    <!-- Col 2 -->
    <div class="col">
        <img src="<?php echo get_field("picture")["url"]; ?>">
    </div>

    <div class="post_contact">
        <div>
            Cette photo vous intéresse ?
        </div>
        <div>
            <div class="btn btn-default" id="SendBtn">
                Contact
            </div>
        </div>
    </div>
</div>



<?php 
// On récupère le slug du terme de la taxonomie "cats"
$terms = get_the_terms( $post->ID, 'cats' );
if ( !empty( $terms ) ){
    // get the first term
    $term = array_shift( $terms );
    $slug = $term->slug;
}

    // Arguments de ce que l'on souhaite afficher
    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 2,
        'post__not_in' => array( $post->ID ),
        'tax_query' => array(             
                array(
                'taxonomy' => 'cats',
                'field' => 'slug',
                'terms' => $slug // On sélectionne les photos du terme de taxonomie "cats" récupéré plus haut                
            ),
        )
    );
    $my_query = new WP_Query( $args );


    // Show section title if there are some results
    if( $my_query->have_posts())
    {
        // Vous aimerez aussi
        echo "<div class='more'><p>Vous aimerez aussi</p></div>";

        // Liste des photos
        echo "<div class='photos marginBottom'>";

        while( $my_query->have_posts() ) : $my_query->the_post();
        ?>
            
            <!-- Affichage de la photo -->
            <div class="photo">
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
        // Réinitialisation de la requête principale (important)
        wp_reset_postdata();
        endwhile;
        echo "</div>";
    }
    
endwhile;
endif;
?>
</div>
<?php get_footer(); ?>