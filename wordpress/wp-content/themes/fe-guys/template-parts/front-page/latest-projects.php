<!--======================================
=            #Latest-Projects            =
=======================================-->
<div class="row section dark" id="section-latest-projects">
	<h2>Latest <span class="green">Projects</span></h2>
	<?php
		$args = array(
			'post_type' => 'projects'
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
	?>
				<div class="slide">
					<div class="col-xs-5 project-details">
							<?php the_content(); ?>
						</div>

						<div class="col-xs-7 project-display">
							<div class="pagination-container">
								<div class="swiper-prev">
									<i class="fa fa-caret-left" aria-hidden="true"></i>
								</div>
								<div class="swiper-pagination"></div>
								<div class="swiper-next">
									<i class="fa fa-caret-right" aria-hidden="true"></i>
								</div>
							</div>

							<img class="display-screen large-screen" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/large-screen.svg' ?>" alt="Large Monitor">
							<div class="swiper-container">
								
								
								
								<div class="swiper-wrapper">
									<?php
									    //Get the images ids from the post_metadata
									    $images = acf_photo_gallery('screenshots', $post->ID);
									    //Check if return array has anything in it
									    if( count($images) ):
									        //Cool, we got some data so now let's loop over it
									        foreach($images as $image):
									        	// print_r($image);
									            $id = $image['id'];
									            $title = $image['title']; //The title

									            $caption= $image['caption']; //The caption
									            $full_image_url= $image['full_image_url']; //Full size image url
									            // $cropped_url = acf_photo_gallery_resize_image($full_image_url, 800, 437); //Resized size to 262px width by 160px height image url
									            // $cropped_url = get_the_post_thumbnail_url($image['id'], 'desktop-screenshots');
									            $screenshot_screen = wp_get_attachment_image_src( $id, 'desktop-screenshots' );
									            $screenshot_screen_src = $screenshot_screen[0];
									            $thumbnail_image_url= $image['thumbnail_image_url']; //Get the thumbnail size image url 150px by 150px
									            $url= $image['url']; //Goto any link when clicked
									            // $target= $image['target']; //Open normal or new tab
									            // $alt = get_field('photo_gallery_alt', $id); //Get the alt which is a extra field (See below how to add extra fields)
									            // $class = get_field('photo_gallery_class', $id); //Get the class which is a extra field (See below how to add extra fields)

									            echo '<div class="swiper-slide">';
									            // echo $id;
									            // echo wp_get_attachment_image( $id, 'desktop-screenshots');
									            echo '	<img src="' . $screenshot_screen_src . '" alt="' . $title . '" title="' . $title .'">';
									            echo '</div>';
								
											endforeach;
										endif;
									?>
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

