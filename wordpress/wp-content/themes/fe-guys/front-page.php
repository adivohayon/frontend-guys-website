<?php
/**
 * The template for displaying the front page
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Frontend_Guys
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div id="fullpage" class="container-fluid">
				<?php get_template_part( 'template-parts/front-page/hello'); ?>
				<?php get_template_part( 'template-parts/front-page/design-and-development'); ?>
				<?php get_template_part( 'template-parts/front-page/latest-projects'); ?>
				<?php get_template_part( 'template-parts/front-page/tech'); ?>
				<?php get_template_part( 'template-parts/front-page/your-project'); ?>
				<?php get_template_part( 'template-parts/front-page/from-our-blog'); ?>
				<?php get_template_part( 'template-parts/front-page/contact-us'); ?>
			</div>
			<!-- #fullpage -->
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
// get_sidebar();
get_footer();
