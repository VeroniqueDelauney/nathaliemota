<?php get_header(); ?>

<main id="primary" class="site-main">

	<!-- Call template of list of photos --VD -->
	<?php 
	include('templates/photo_block.php');
	?>


	<?php get_the_title(); ?>
	<!-- <?php the_content(); ?> -->

	<?php
	// Templates list of photos -- VD
	include('templates/photos_list.php');
	?>

	</main><!-- #main -->

<?php get_footer(); ?>