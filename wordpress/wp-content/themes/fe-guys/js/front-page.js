( function( $ ) {
/*===============================================
=            Fullpage Implementation            =
===============================================*/
	var currentProjectSlide = 0;
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
			lazyLoading: true,
			afterSlideLoad: function(anchorLink, sectionIndex, slideAnchor, slideIndex) {
				if (anchorLink == 'latest-projects') {
					currentProjectSlide = slideIndex;
				}
			},
			onSlideLeave: function(anchorLink, index, slideIndex, direction, nextSlideIndex){
				if (anchorLink == 'latest-projects') {
				}
			},
			onLeave: function(index, nextIndex){
		          	if(nextIndex == 1){
		               $('.site-header').hide();
		          	}else{
		               $('.site-header').show();
		               //$('#animated-arrow').hide();   
		          	}
		      	},
			autoScrolling: false,
			fitToSection: false
		});
	}
/*==================  End of Fullpage Implementation  ===================*/

/*===============================================
=            Hello Section 			            =
===============================================*/
	function initHello() {
		$("#section-hello h2 span").typed({
			strings: ["Developers turned Designers", "Designers turned Developers"],
			typeSpeed: 30,
			loop: true,
			startDelay: 1500,
			backDelay: 2000
		});
	}
/*======================  End of Hello Secion  ========================*/

/*===============================================
=            Latest Projects Section            =
===============================================*/
	//Project Display Slider
	var projectDisplaySlider;
	var currentAssetTypeTitle = 'Screenshots';
	function setupProjectDisplaySlider() {
		projectDisplaySlider = new Swiper ('.project-display .swiper-container', {
			// Optional parameters
			slidesPerView: 1,
			loop: true,
			loopAdditionalSlides: 0,
			nextButton: '.project-display .swiper-next',
	        prevButton: '.project-display .swiper-prev',
	        pagination: '.project-display .swiper-pagination',
	        paginationType: 'fraction',
	        paginationFractionRender: function (swiper, currentClassName, totalClassName) {
				return 	'<span class="asset-type">' + currentAssetTypeTitle + '</span> ' +
						'(<span class="' + currentClassName + '"></span>' +
						' / ' +
						'<span class="' + totalClassName + '"></span>)';
			}
		});

		/*====================================================================
		=            Load Screenshots of first project as Default            =
		====================================================================*/
		var projectDomId = $('#section-latest-projects .project').first().attr('id');
		var projectId = projectDomId.substring(projectDomId.indexOf('-') + 1);
		//Replace assets in screen
		switchAssets('screenshots', projectId);
		$('.asset-navigation-item').first().addClass('active');

	}

	function getAssetsByProject(projectId, assetType) {
		var payload = {
			action: 'project_assets',
			security: wpAjaxObj.security,
			project_id: projectId,
			asset_type: assetType ? assetType : false
		};
		// console.log('payload', payload);

		return $.ajax({
			url:wpAjaxObj.url,
			data:payload, // form data
			type:'post', // POST
			beforeSend:function(xhr){
			},
			success:function(data){
			}
		});
	}

	var paginationEnabled = true;
	function switchAssets(assetType, projectId) {
		//Get assets by asset type and project Id
		getAssetsByProject(projectId, assetType).done(function(assets) {
			// console.log('getAssetsByProject', assets);

			/*====================================
			=            Reset Slider            =
			====================================*/
			//Select current slider
			var slider = currentProjectSlide > 0 ? projectDisplaySlider[currentProjectSlide] : projectDisplaySlider;
			if (slider) {
				slider.removeAllSlides();
			}

			/*=========================================
			=            Create New Slides            =
			=========================================*/
			var newSlides = [];
			assets.forEach(function(asset) {
				var slide = '<div class="swiper-slide asset">';

				switch (assetType) {
					case 'screenshots':
						slide += '<img src="' + asset.screen_src + '" alt="' + asset.title + '" title="' + asset.title +'">';
						break;
					case 'videos':
						slide += '<div class="youtube-embed">' + asset + '</div>';
						break;
				}
				slide += '</div>';
				newSlides.push(slide);
			});
			
			/*==================================
			=            Pagination            =
			==================================*/
			function togglePagination(enabled) {
				//if it's enabled, disable
				if (enabled) {
					slider.unlockSwipes();
					$('.project-display .swiper-arrows').fadeTo( "fast" , 1);
				} 
				//if it's disabled, enable
				else {
					slider.lockSwipes();
					$('.project-display .swiper-arrows').fadeTo( "fast" , 0.4);
				}
			}

			//if there is only one slide, disable pagination
			if (newSlides.length === 1) {
				togglePagination(false);
			}
			//if there is more than one slide, enable pagination
			else if (newSlides.length > 1) {
				togglePagination(true);
			}

			/*=====================================
			=            Append Slides            =
			=====================================*/
			if (newSlides.length > 0) {
				slider.appendSlide(newSlides);
				slider.slideTo(1);
			}

		});
		
	}

	function handleProjectAssetNavigation() {
		$('.project-assets-navigation li a').click(function(event) {
			//Stop other events
			event.preventDefault();
			event.stopPropagation(); 

			//Get clicked Asset Type name and title
			var assetType = $(this).attr('data-attr');
			var assetTypeTitle = $(this).attr('title');
			$('.asset-navigation-item').removeClass('active');
			$(this).addClass('active');
			// console.log('assetType', assetType);
			

			//Get current project ID
			var projectDomId = $(this).closest('.project').attr('id');
			var projectId = projectDomId.substring(projectDomId.indexOf('-') + 1);
			// console.log('Current Project ID', projectId);

			//Replace assets in screen
			currentAssetTypeTitle = assetTypeTitle;
			switchAssets(assetType, projectId);
		});
	}

/*=====================  End of Latest Project Section  ======================*/
	

	
/*====================================================
=            Tech Section                            =
====================================================*/
	var techSlider;
	function setupTechSlider() {
		techSlider = new Swiper ('.tech-icons.swiper-container', {
			// Optional parameters
			slidesPerView: 6,
			loop: false
		});
	}

	function getTechByCategory(category) {
		var payload = {
			action: 'filter_posts',
			security: wpAjaxObj.security,
			tech_tag: category || 'development'
		};
		// console.log('ajax payload', payload);

		return $.ajax({
			url: wpAjaxObj.url,
			data: payload, 
			type:'post', // POST
			beforeSend:function(xhr){
			},
			success:function(data){
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
/*=====================  End of Tech Section  ======================*/

/*==================================
=            Init Forms            =
==================================*/
	function initForms() {
		var selectors = '.fe-form input, .fe-form textarea';
		$(selectors).focus(function() {
			$(this).addClass('input-focused');
			$(this).closest('li').find('i').addClass('input-focused');
		});

		$(selectors).blur(function() {
			if (! $(this).val() ) {
				$(this).removeClass('input-focused');
				$(this).closest('li').find('i').removeClass('input-focused');
			}
		});
	}



	

	function initAllSliders() {
		setupProjectDisplaySlider();
		setupTechSlider();
	}

	$(document).ready(function() {
		initFullPage();
		initHello();
		initAllSliders();
		handleProjectAssetNavigation();
		initTechTags();
		initForms();

		// getTechByCategory();
	});
} )( jQuery );