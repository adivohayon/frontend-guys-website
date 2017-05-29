<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Frontend_Guys
 */

?>


<?php
	$categories = get_the_category();
	$category = array_pop($categories);
	$category_color = get_field('term_color', $category );
	$color_class = get_field('is_dark', $category ) ? 'post-dark' : '';
	// wp_list_categories();


	// print_r($category);
?>
<article id="post-<?php the_ID(); ?>"  <?php post_class($color_class); ?> style="background-color: <?php echo $category_color; ?>">

	<header class="entry-header">
		<?php
		if ( is_single() ) :
			the_title( '<h3 class="entry-title">', '</h3>' );
		else :
			the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
		endif;

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php fe_guys_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			
			the_excerpt();
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php fe_guys_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
