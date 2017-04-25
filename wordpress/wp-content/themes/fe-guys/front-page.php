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
		<main id="main" class="site-main container-fluid" role="main">
			<!--============================
			=            #Hello            =
			=============================-->
			<div class="row" id="hello">
				<div class="col-xs-12">
					<h2>Developers Turned Designers</h2>
				</div>
			</div><!-- #hello -->

			<!--========================================
			=            #Be-A-Frontend-Guy            =
			=========================================-->
			<div class="row" id="be-a-frontend-guy">
				<div class="col-xs-12">
					<h2>Be a</h2>
				</div>
			</div><!-- #be-a-frontend-guy -->

			<!--======================================
			=            #Latest-Projects            =
			=======================================-->
			<div class="row" id="latest-projects">
				<div class="col-xs-12">
					<h2>Latest <span class="green">Projects</span></h2>
				</div>
			</div><!-- #latest-projects -->

			<!--===========================
			=            #Tech            =
			============================-->
			<div class="row" id="tech">
				<div class="col-xs-12">
					<h2>Our Choice of <span class="green">Tech</span></h2>
				</div>
			</div><!-- #tech -->

			<!--===================================
			=            #Your-Project            =
			====================================-->
			<div class="row" id="your-project">
				<div class="col-xs-12">
					<h2>Your <span class="green">Project</span></h2>
				</div>
			</div><!-- #your-project -->

			<!--====================================
			=            #From-Our-Blog            =
			=====================================-->
			<div class="row" id="from-our-blog">
				<div class="col-xs-12">
					<h2>From Our <span class="green">Blog</span></h2>
				</div>
			</div><!-- #from-our-blog -->

			<!--=================================
			=            #Contact-Us            =
			==================================-->
			<div class="row" id="contact-us">
				<div class="col-xs-12">
					<h2>Contact <span class="green">Us</span></h2>
				</div>
			</div><!-- #contact-us -->

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
