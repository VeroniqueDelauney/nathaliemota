<?php get_header(); ?>
<div class="main single">
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
<?php
    $ID = get_the_ID();
?>


<div class="post">
    <div class="top">
        <!-- Col 1 -->
        <div class="col">
            <h1 class="post-title"><?php the_title(); ?></h1>
            <p>
                Référence : <?php echo get_field("reference"); ?>
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
            <!-- Affichage de l'image avec taille optimisée par Smush -->
            <img src="<?php echo get_field('picture')['sizes']['large']; ?>" alt="<?php the_title(); ?>">
        </div>
    </div>
    <div class="col post_contact">
        <div class="contact">
            <div>
                Cette photo vous intéresse ?                
            </div>
            <div>
                <div class="btn btn-default contact-btn reference" data-ref="<?php echo(get_field("reference")); ?>">
                    <a>Contact</a>
                </div>
            </div>
        </div>
        <div class="miniature">
            <div class="visionneuse">
                <div class="thumbnail">                    
                    <?php 
                    $previous_post = get_previous_post();
                    $next_post = get_next_post();

                    // Affichage de l'image avec taille optimisée par Smush
                    if($previous_post) {
                        echo '<div class="prev"><img src="' . get_field("picture", $previous_post->ID)['sizes']['thumbnail'] .'" alt="Image précédente"></div>';
                    }

                    if($next_post) {
                        echo '<div class="next"><img src="' . get_field("picture", $next_post->ID)["url"] .'" alt="Image suivante"></div>';
                    }
                    ?>          
                </div>
                <div class="navigationArrows">
                    <div>
                        <!-- Previous link -->
                        <?php 
                            if (!empty($previous_post)) {
                                echo '<a href="' . get_permalink($previous_post) . '" title="Voir la photo précédente" class="prev_arrow"><-</a>';
                            }
                        ?>
                    </div>
                    <div>
                        <!-- Next link -->
                        <?php
                        if (!empty($next_post)) { 
                            echo '<a href="' . get_permalink($next_post) . '" title="Voir la photo suivante" class="next_arrow">-></a>';
                        }
                        ?>
                    </div>
                </div>                
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
        echo "<div class='photos marginBottom' id='picturesContainer'>";

        while( $my_query->have_posts() ) : $my_query->the_post();

        // On appelle le template bloc_photo.php qui retourne une photo mise en page
        include('templates/photo_block.php');

        
        endwhile;

        // Réinitialisation de la requête principale (important)
        wp_reset_postdata();

        echo "</div>";
    }
    
endwhile;
endif;
?>
</div>

<div class="lightbox">
    
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
    <div class="lightbox_close" alt="Fermer"></div>
</div>

<?php get_footer(); ?>



