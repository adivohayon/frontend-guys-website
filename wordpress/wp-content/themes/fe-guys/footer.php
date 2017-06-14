<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Frontend_Guys
 */

?>
	
	</div><!-- #content -->
	<footer id="site-footer">
		<?php
			if (is_single()) {
				echo '<div>' . next_post_link() . '</div>';
			}
		?>
		<div class="footer-content">
			footer content
		</div>
		<?php
			if (is_single()) {
				echo '<div>' . next_post_link() . '</div>';
			}
		?>
	</footer>

	<!-- footer -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
