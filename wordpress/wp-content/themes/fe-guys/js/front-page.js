( function( $ ) {
	var tempSelector = '';
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
					// console.log('Updating currentProjectSlide', currentProjectSlide);
				}
			},
			onSlideLeave: function(anchorLink, index, slideIndex, direction, nextSlideIndex){
				if (anchorLink == 'latest-projects') {
					//get next slide's project id
					// console.log('nextSlideIndex', nextSlideIndex);
					//load next slide via ajax
					// getAssetsByProject(projectId).done(function(assets) {
					// 	console.log('assets', assets);
					// });
					//append data to dom
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

	function switchAssets(assetType, projectId) {
		//Get assets by asset type and project Id
		getAssetsByProject(projectId, assetType).done(function(assets) {
			console.log('getAssetsByProject', assets);

			//Remove current assets
			if (projectDisplaySlider) {
				if (currentProjectSlide > 0 ){
					projectDisplaySlider[currentProjectSlide].removeAllSlides();
				} else {
					projectDisplaySlider.removeAllSlides();
				}
			}

			//Append new slides
			var newSlides = [];
			assets.forEach(function(asset) {
				var slide = '<div class="swiper-slide asset">' +
								'<div class="spinner">' +
									'<div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div>' +
								'</div>';
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

			//Append new slides
			if (currentProjectSlide > 0 ){
				projectDisplaySlider[currentProjectSlide].appendSlide(newSlides);
			} else {
				projectDisplaySlider.appendSlide(newSlides);
			}
			

		});
		
	}

	function handleProjectAssetNavigation() {
		tempSelector = '.project-assets-navigation li a';
		$(tempSelector).click(function(event) {
			//Stop other events
			event.preventDefault();
			event.stopPropagation(); 

			//Get clicked Asset Type name and title
			var assetType = $(this).attr('data-attr');
			var assetTypeTitle = $(this).attr('title');
			console.log('assetType', assetType);

			

			//Get current project ID
			var projectDomId = $(this).closest('.project').attr('id');
			var projectId = projectDomId.substring(projectDomId.indexOf('-') + 1);
			console.log('Current Project ID', projectId);

			//Replace assets in screen
			currentAssetTypeTitle = assetTypeTitle;
			switchAssets(assetType, projectId);


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

	function getTechByCategory(category) {
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
		initHello();
		initAllSliders();
		handleProjectAssetNavigation();
		initTechTags();

		// getTechByCategory();
	});
} )( jQuery );