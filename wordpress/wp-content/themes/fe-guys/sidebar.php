<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Frontend_Guys
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area" role="complementary">
	<div class="sidebar">
		<?php
			$args = array(
				'before_title' => '<h6 class="seperator">',
				'after_title' => '</h6>'
			);
			$instance = array(
				'title' => 'Latest Posts',
				'number' => 5
			);

			the_widget('WP_Widget_Recent_Posts', $instance, $args);
			echo '<ul>';
			walk_post_categories(1);
			echo '</ul>';

		?>
		<div class="sidebar-request-quote">
			<h5>Looking for Design and Development Help?</h5>
			<button class="btn-primary">Request Quote</button>
		</div>
		<?php //dynamic_sidebar( 'sidebar-1' ); ?>
	</div>
</aside><!-- #secondary -->
