( function( $ ) {
	/*===============================================
	=            Fullpage Implementation            =
	===============================================*/
	function initFullPage() { 
		$('.site-header').hide();
		$('#fullpage').fullpage({
			verticalCentered: false,
			anchors: ['hello', 'design-and-development', 'latest-projects', 'tech', 'your-project', 'contact-us'],
			resize: false,	
			// navigation:true,
			menu: '#primary-menu',
			loopHorizontal: true,
			responsiveWidth: 768,
			onLeave: function(index, nextIndex){
		          	if(nextIndex == 1){
		               $('.site-header').hide();
		          	}else{
		               $('.site-header').show();
		               //$('#animated-arrow').hide();   
		          	}
		      	},
			autoScrolling: false,
		});
	}

	/*====================================
	=            Tech Section            =
	====================================*/
		function getTechByCategory(category, cb) {
			var payload = {
				action: 'filter_posts',
				security: wpAjaxObj.security,
				tech_tag: category || 'development'
			};
			console.log('ajax payload', payload);

			return $.ajax({
				url:wpAjaxObj.url,
				data:payload, // form data
				type:'post', // POST
				beforeSend:function(xhr){
					// filter.find('button').text('Processing...'); // changing the button label
				},
				success:function(data){
					// cb(data);
					// console.log('data', data);
					// filter.find('button').text('Apply filter'); // changing the button label back
					// $('#response').html(data); // insert data
				}
			});
		}

		function initTechTags() {
			$('.tech-tag').click(function(event) {
				var term = $(this).attr('data-term');
				console.log('aaa', term);
				getTechByCategory(term).done(function(technologies) {
					techSwiper.removeAllSlides();
					var html = '';
					var slides = [];
					console.log('new technologies', technologies);
					technologies.forEach(function(tech) {
						var html = '<div class="swiper-slide">';
								html += '<a href="#" title="' + tech.title + '" class="' + tech.image_orientation + '">';
									html += '<img src="' + tech.image + '">';
								html += '</a>';
							html += '</div>';
						slides.push(html);						
					});
					techSwiper.appendSlide(slides);
					// $('.swiper-container .swiper-wrapper').html(html);
					
				});
			});
		}


	
	
	var techSwiper;
	function initSwipers() {
		techSwiper = new Swiper ('.swiper-container', {
			// Optional parameters
			slidesPerView: 6,
			loop: false
		});
	}



	$(document).ready(function() {
		console.log('aaaa');
		initFullPage();
		initSwipers();
		initTechTags();
		getTechByCategory();
	});
} )( jQuery );