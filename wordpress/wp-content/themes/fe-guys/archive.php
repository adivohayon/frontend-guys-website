<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Frontend_Guys
 */
  
get_header(); 

$obj = get_queried_object();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div id="archive" class="menu-padding">
				<header class="row">
					<div class="col-xs-12">
						<div class="header-image">
							<?php 
								if (is_category()) {
									echo do_shortcode('[wp_custom_image_category  
										size="full" 
										term_id="' . $obj->cat_ID . '" 
										alt="'. $obj->cat_name . '"
									]');
								}

								if (is_author()) {
									the_author_image($obj->ID); 

								}
							?>
						</div>
						<div class="header-title">
							<h2><span class="green"><?php echo is_author() ? $obj->display_name . '\'s' :  $obj->cat_name; ?></span> Archive</h2>
						</div>

						
					</div>
				</header>
				<div class="row">
					<div class="col-xs-9 content-padding-left">
						<?php
							/* Start the Loop */
							while ( have_posts() ) : the_post();

								/*
								 * Include the Post-Format-specific template for the content.
								 * If you want to override this in a child theme, then include a file
								 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
								 */
								get_template_part( 'template-parts/content', 'post_excerpt' );

							endwhile;

							the_posts_navigation();
						?>
					</div>
					<div class="col-xs-3">
						<?php get_sidebar(); ?>
					</div>
				</div>
			</div>

		<?php
		if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
