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

<!-- Vous aimerez aussi -->
<div class="more">
    <p>Vous aimerez aussi</p>
</div>



<!-- Liste des photos -->
<div class="photos marginBottom">

    <?php 
    // Arguments de ce que l'on souhaite afficher
    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 2
    );

    // Exécution appel WP Query
    $my_query = new WP_Query( $args );

    // Boucle
    if( $my_query->have_posts() ) : while( $my_query->have_posts() ) : $my_query->the_post();
    ?>

    <!-- Affichage de la photo -->
    <div class="photo">
        <a href="<?php the_permalink(); ?>" title="Voir la photo '<?php the_title(); ?>'">
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
</div>



<?php endwhile; ?>
<?php endif; ?>
</div>
<?php get_footer(); ?>