<!--====================================
=            #From-Our-Blog            =
=====================================-->


<div class="row section" id="section-from-our-blog">
	<div class="col-xs-12">
		<div class="latest-posts">
			<h2>From Our <span class="green">Blog</span></h2>
			<?php
				$args = array(
					'numberposts' => 4,
					'orderby' => 'post_date',
					'order' => 'DESC',
					'include' => '',
					'exclude' => '',
					'meta_key' => '',
					'meta_value' =>'',
					'post_type' => 'post',
					'post_status' => 'publish',
					'suppress_filters' => true
				);
				$recent_posts = wp_get_recent_posts( $args, ARRAY_A );
				$number_of_posts = count($recent_posts);
				$counter = 0;
				foreach( $recent_posts as $recent ) :
					setup_postdata($recent);
					$content= $recent["post_content"];
					$excerpt = wp_trim_words( 
						$content, 
						$num_words = 20, 
						$more = '<div class="read-more accent"><a href="' . get_permalink($recent["ID"]) . '">Read More</a></div>' 
					);
					if ($counter % 2 === 0) echo '<div class="row">'; 	           
			?>
					<!-- HTML stuff -->
					<div class="col-sm-6 col-xs-12">
						<div class="image-container">
							<?php
								if ( has_post_thumbnail($recent["ID"]) ) {
					               echo get_the_post_thumbnail($recent["ID"], 'Latest Posts');
					           }
					           // $recent["post_title"];
							?>
						</div>
						<div class="post-container <?php if ( has_post_thumbnail($recent["ID"]) ) {
								echo '';
							} else {
								echo 'full-width';
							} ?>">
							<h5><?php echo '<a class="post-link" href="' . get_permalink($recent["ID"]) . '" title="' . $recent["post_title"] . '">' . $recent["post_title"] . '</a>'; ?></h5>
							<div class="post-details">
								<?php echo get_the_date('', $recent["ID"]);?> by <?php 
									$author_id = $recent['post_author'];
									$author_name = get_the_author_meta('user_nicename', $author_id);
									$author_url = get_author_posts_url($author_id);
									echo '<a href="' . esc_url($author_url) . '" title="' . $author_name . ' archive">' . $author_name . '</a>';
									?> in <?php
									$post_categories = wp_get_post_categories($recent["ID"]);
									$categories = array();
									foreach($post_categories as $category_id){
										$category = get_category($category_id);
										// print_r($category);
										$categories[] = array('name' => $category->name, 'link' => get_category_link($category_id));
									}
									echo '<a href="' . esc_url($categories[0]['link']) . '" title="' . $categories[0]['name'] . '">' . $categories[0]['name'] . '</a>';
								?>
							</div>
							<p class="description"><?php echo $excerpt; ?></p>
						</div>
					</div>
					
			<?php
					$counter++;
					if ($counter % 2 === 0 || $counter === $number_of_posts) {
						echo '</div>';
					}
				endforeach;
				wp_reset_query();
			?>

		</div>
		<!-- /.latest-posts -->
	</div>
</div><!-- #section-from-our-blog -->
<!-- #section-from-our-blog -->