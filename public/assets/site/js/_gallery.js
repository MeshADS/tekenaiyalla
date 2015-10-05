var galleryJS = new function(){

	function initGallery(){
	    // Init inline Fancybox
	  $(".fancyboxBtn").fancybox({ 
	  	overlay : { locked : false },
	  	autoDimensions:false,
	  	width:560
	  });
	}

	function initMasonry () {
		$(function(){
			$albumListContainer = $('#album-list')
			$albumListContainer.imagesLoaded(function(){
				$albumListContainer.masonry({
				   	itemSelector: '.album-item',
					columnWidth: 0,
					gutterWidth: 0
				});	
			});	
		});
	}
	/*
		Init function for page JS
	*/
	this.init = function(){
		initGallery();	
		initMasonry();	
	};
};