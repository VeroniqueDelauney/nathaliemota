<?php get_header(); ?>

<main id="primary" class="site-main home">

	<!-- Affichage de la photo aléatoire du hero -->
	<?php 
	include('templates/full_banner.php');
	?>

	<?php get_the_title(); ?>

	<?php
	// Affichage du catalogue de photos qui contient le CPT "photos"
	include('archive-photos.php');
	?>

</main>

<?php get_footer(); ?>