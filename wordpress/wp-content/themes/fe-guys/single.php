<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Frontend_Guys
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();
		?>
			<div id="blog-post" class="menu-padding">
				<header class="blog-header row">
					<?php 
						if ( has_post_thumbnail() ) {
							echo '<div class="header-image">';
							the_post_thumbnail();
							echo '</div>';
						}
					?> 
					<div class="header-title">
						<?php 
							the_title( '<h2>', '</h2>' );
							if ( 'post' === get_post_type() ) {
							echo '<div class="entry-meta">';
									fe_guys_posted_on();
								echo '</div><!-- .entry-meta -->';
							}
						?>
					</div>

					
					

						
				
				</header>
				<div class="row">
					<div class="col-xs-9 content-padding-left">
						<?php
							/* Start the Loop */

								/*
								 * Include the Post-Format-specific template for the content.
								 * If you want to override this in a child theme, then include a file
								 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
								 */
								get_template_part( 'template-parts/content',  get_post_format() );

							
						?>
					</div>
					<div class="col-xs-3">
						<?php get_sidebar(); ?>
					</div>
				</div>
			</div>
			<?php
				endwhile;

				// the_posts_navigation();

				the_post_navigation();

				// If comments are open or we have at least one comment, load up the comment template.
				// if ( comments_open() || get_comments_number() ) :
				// 	comments_template();
				// endif;
			?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();
