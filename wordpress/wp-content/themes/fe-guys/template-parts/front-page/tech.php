<!--===========================
=            #Tech            =
============================-->
<div class="row section" id="section-tech">
	<div class="col-xs-12">
		<h2>Our Choice of <span class="green">Tech</span></h2>
		<div class="content accent-bg">
			<!--================================
			=            .Tech-Tags            =
			=================================-->
			<div class="tech-tags">
				<ul>
					<?php
						$terms = get_terms( array(
						    'taxonomy' => 'tech_categories',
						    'hide_empty' => false,
						) );
						foreach ( $terms as $term ) {
						    echo '<li class="tech-tag" data-term="' . $term->slug . '">' . $term->name . '</li>';
						}
					?>
				</ul>
			</div>
			<!-- .tech-tags -->
			
			<!--=================================
			=            .Tech-Icons            =
			==================================-->
			<!-- Slider main container -->
			<div class="tech-icons swiper-container">
			    <!-- Additional required wrapper -->
			    <div class="swiper-wrapper">
			        <!-- Slides -->
			        <?php
			        	$args = array(
			        		'post_type' => 'tech',
			        		'tax_query' => array(
			        			array(
			        				'taxonomy' => 'tech_categories',
			        				'field'    => 'slug',
			        				'terms'    => 'development',
			        			),
			        		),
			        	);
			        	$query = new WP_Query( $args );
			        	// The Loop
			        	if ( $query->have_posts() ) : 
			        		while ( $query->have_posts() ) : 
			        			$query->the_post();
			        			if ( has_post_thumbnail() ) :
			        ?>
									<div class="swiper-slide">
										<?php 
											$orientation = get_field( "image_orientation" );
											$class = $orientation ? 'class="' . $orientation . '" ' : '';
										?>
										<a href="#" title="<?php echo get_the_title();?>" <?php echo $class; ?>>
											<?php the_post_thumbnail(); ?>
										</a> 
									    <!-- <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>  -->
									</div>
								<?php endif; // has_post_thumbnail ?>
			        		<?php 
			        		endwhile; 
			        		wp_reset_postdata();
			        		?>
			 			<?php else : ?>
			 				<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
			 			<?php endif; ?>
			    </div>
			    <!-- If we need pagination -->
			    <div class="swiper-pagination"></div>
			    
			    <!-- If we need navigation buttons -->
			    <div class="swiper-button-prev"></div>
			    <div class="swiper-button-next"></div>
			    
			    <!-- If we need scrollbar -->
			    <div class="swiper-scrollbar"></div>
			</div>
			<!-- .tech-icons-->

			
		</div>
		
	</div>
</div><!-- #section-tech -->