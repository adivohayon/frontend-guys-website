<!--======================================
=            #Latest-Projects            =
=======================================-->
<div class="row section dark" id="section-latest-projects">
	<h2>Latest <span class="green">Projects</span></h2>
	<?php
		$args = array(
			'post_type' => 'projects',
			'posts_per_page' => 5
			// 'tax_query' => array(
			// 	array(
			// 		'taxonomy' => 'tech_categories',
			// 		'field'    => 'slug',
			// 		'terms'    => 'development',
			// 	),
			// ),
		);
		$query = new WP_Query( $args );
		// The Loop
		if ( $query->have_posts() ) : 
			while ( $query->have_posts() ) : 
				$query->the_post();
				
				$images = acf_photo_gallery('screenshots', $post->ID);
				
				$videos = array();
				if ( get_field("video-1") ) {
					array_push($videos, get_field("video-1"));
				}
				if ( get_field("video-2") ) {
					array_push($videos, get_field("video-2"));
				}
				if ( get_field("video-3") ) {
					array_push($videos, get_field("video-3"));
				}
				if ( get_field("video-4") ) {
					array_push($videos, get_field("video-4"));
				}

	?>
				<div class="slide project" id="project-<?php echo $post->ID; ?>" data-anchor="<?php echo $post->post_name; ?>">
					<div class="col-xs-5 project-details">
						<div class="project-header">
							<div class="project-logo">
								<?php
									if ( has_post_thumbnail() ) {
								    	the_post_thumbnail('medium');
									} else {
										the_title('<h3>', '</h3>');
									}
								?>
							</div>
							<?php if (get_field("project-tagline")) :?>
								<div class="project-tagline">
									<span>Tagline: </span><?php echo get_field("project-tagline"); ?>
								</div>
							<?php endif;?>
						</div>
						<div class="project-description content-padding">
							<?php the_content(); ?>	
						</div>
						<div class="project-assets-navigation content-padding">
							<hr />
							<ul>
								<?php
									if ( count($images) ) {
										echo '<li><a class="asset-navigation-item" href="project/screenshots" title="Screenshots" data-attr="screenshots">Screenshots</a></li>';
									}

									
									if ( count($videos) ) {
										echo '<li><a class="asset-navigation-item" href="project/videos" title="Videos" data-attr="videos">Videos</a></li>';
									}
								?>
							</ul>
						</div>
					</div>

					<div class="col-xs-7 project-display">
						

						

						<div class="visual desktop-screen">
							<img class="display-screen large-screen" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/large-screen.svg' ?>" alt="Large Monitor">
							<div class="screen-content swiper-container">
								<div class="spinner">
									<div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div>
								</div>
								
								
								<div class="swiper-wrapper">
									
								</div>
							</div>

							<div class="top-position pagination-container">
								<div class="swiper-prev swiper-arrows">
									<i class="fa fa-caret-left" aria-hidden="true"></i>
								</div>
								<div class="swiper-pagination"></div>
								<div class="swiper-next swiper-arrows">
									<i class="fa fa-caret-right" aria-hidden="true"></i>
								</div>
							</div>
						</div>
					</div>
				</div>

       		<?php 
       		endwhile; 
       		wp_reset_postdata();
       		?>
	<?php else : ?>
		<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
	<?php endif; ?>

</div><!-- #section-latest-projects -->

