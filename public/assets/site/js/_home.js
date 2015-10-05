var homeJS = new function(){

	var slider;
	
	/**
	 * Starts home slider
	*/
	function slider_init(){
		// Init slider
		slider = $(".heroslider").owlCarousel({
					"loop":true,
				  	"margin":0,
				  	"autoplay":true,
				  	"autoplayHoverPause":true,
				  	"autoplayTimeout":7000,
				  	responsive:{
						        0:{
						            items:1
						        },
						        992:{
						            items:1
						        }
						    }
				});
				// Call nav function
				slider_navigation();
	}
	
	/**
	 * Centers the slider navigation vertically
	*/
	function reposition_slider_nav(){
		// Variables
		var navheight = $(".heroslider-nav .nav-item").outerHeight(), // Grab slider nav height
			sliderHeight = $(".heroslider").outerHeight(), // Grab slider height
			newPos = ( sliderHeight - navheight ) / 2; // Calculate new top position
			// Set nav item new top position ( CSS Injection )
			$(".heroslider-nav .nav-item").css({top:newPos+"px"});
	}

	/**
	 * Slider navigation function
	*/
	function slider_navigation(){
		// Variables
		navItem = $(".heroslider-nav .nav-item"); // Grab nav items
		// Add click event listener to nav items
		navItem.click(function(event){	
			// Determine event type
			if($(this).hasClass("next"))
			{
				// Go to next slide
				slider.trigger('next.owl.carousel');
			}
			else if($(this).hasClass("prev")){
				// Gor to previuos slide
				slider.trigger('prev.owl.carousel');
			}
			else{
				// Do nothing
			}
			// Element default action
			event.preventDefault();
		});
		// Reposition slider nav
		waitForFinalEvent(function(){
			reposition_slider_nav();
		}, 500, "yadiya");

	}

	/**
	 * Window events listener for home page
	*/
	function homeWindowEventsListener(){

		// Resize listener
		$(window).resize(function(){
			// Delay event
			waitForFinalEvent(function(){
				reposition_slider_nav();
			}, 500, "yadiya");
		});
	}

	/*
		*Init function for home JS
	*/
	this.init = function(){
		slider_init();
		homeWindowEventsListener();
	};
};