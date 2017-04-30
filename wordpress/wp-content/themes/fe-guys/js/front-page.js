( function( $ ) {
	function initFullPage() { 
		$('.site-header').hide();
		$('#fullpage').fullpage({
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

	$(document).ready(function() {
		console.log('aaaa');
		initFullPage();



	});
} )( jQuery );