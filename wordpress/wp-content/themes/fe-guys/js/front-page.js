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
	/*===============================================
	=            Latest Projects Section            =
	===============================================*/
	//Project Display Slider
	var projectDisplaySlider;
	function setupProjectDisplaySlider() {
		projectDisplaySlider = new Swiper ('.project-display .swiper-container', {
			// Optional parameters
			slidesPerView: 1,
			loop: true,
			nextButton: '.project-display .swiper-next',
	        prevButton: '.project-display .swiper-prev',
	        pagination: '.project-display .swiper-pagination',
	        paginationType: 'fraction',
	        paginationFractionRender: function (swiper, currentClassName, totalClassName) {
				return 	'Screenshots ' +
						'(<span class="' + currentClassName + '"></span>' +
						' / ' +
						'<span class="' + totalClassName + '"></span>)';
			}
		});
	}


	
	
	/*====================================
	=            Tech Section            =
	====================================*/
	var techSlider;
	function setupTechSlider() {
		techSlider = new Swiper ('.tech-icons.swiper-container', {
			// Optional parameters
			slidesPerView: 6,
			loop: false
		});
	}

	function getTechByCategory(category, cb) {
		var payload = {
			action: 'filter_posts',
			security: wpAjaxObj.security,
			tech_tag: category || 'development'
		};
		// console.log('ajax payload', payload);

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
		var term = 'development'; //Default value

		//Add Technologies as Swiper Slides
		function addTechnologies(technologies) {
			techSlider.removeAllSlides();
			var html = '';
			var slides = [];
			// console.log('new technologies', technologies);
			technologies.forEach(function(tech) {
				var html = '<div class="swiper-slide">';
						html += '<a href="#" title="' + tech.title + '" class="' + tech.image_orientation + '">';
							html += '<img src="' + tech.image + '">';
						html += '</a>';
					html += '</div>';
				slides.push(html);						
			});
			techSlider.appendSlide(slides);
		}

		getTechByCategory(term).done(function(technologies) {
			addTechnologies(technologies);
		});

		//Click Event Handling
		$('.tech-tag').click(function(event) {
			term = $(this).attr('data-term');
			// console.log('term', term);
			getTechByCategory(term).done(function(technologies) {
				addTechnologies(technologies);
			});
		});
	}


	

	function initAllSliders() {
		setupProjectDisplaySlider();
		setupTechSlider();
	}

	$(document).ready(function() {
		initFullPage();
		initAllSliders();
		initTechTags();
		// getTechByCategory();
	});
} )( jQuery );