<?php get_header(); ?>

<main id="primary" class="site-main home">

	<!-- Call template of list of photos --VD -->
	<?php 
	include('templates/photo_block.php');
	?>

	<?php get_the_title(); ?>
	<!-- <?php the_content(); ?> -->

	<?php
	// On appelle la page archive-photos.php qui contient le CPT "photos" -- VD
	include('archive-photos.php');
	?>

	</main><!-- #main -->

<?php get_footer(); ?>