<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package nathaliemota
 */
?>
</div>


	<footer class="site-footer">
            <div>
                  <!-- Nouvelle zone de menu -->
                  <?php wp_nav_menu( array( 'theme_location' => 'footer-menu', 'container_class' => 'footer' ) ); ?>
            </div>
	</footer>


<?php wp_footer(); ?>

</body>

<!-- Appel de la modal -->
<?php get_template_part( 'templates/modal' ); ?>

</html>