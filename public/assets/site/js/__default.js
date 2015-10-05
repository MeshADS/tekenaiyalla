(function(){

	var defaultsJs = {

		/**
		 * Sticks header to top of window
		*/
		stickynav: function(){
			var scrollsize = $(window).scrollTop(),
				headerheight = $("header").outerHeight();
				// Validate scroll size
				if (scrollsize > headerheight) {
					// Check for "sticky" class on header
					if ( ! $("header").hasClass("sticky") ) {
						// Add sticky class to header
						$("header").addClass("sticky");
					};
				}
				else{
					// Check for "sticky" class on header
					if ( $("header").hasClass("sticky") ) {
						// Remove sticky class
						$("header").removeClass("sticky");
					};
				}
		},

		/**
		 * Functions associated with the mobile menu
		*/
		mobilemenu: function(){
			// Add click event listener to mobile menu toggler
			$("#mobile-menu-toggler").click(function(event){
				// Variables
				var mobileMenu = $(".mobile-menu-list"),
					submenus = $(".mobile_menu .has-sub .sub");
					submenusToggler = $(".mobile-menu .has-sub >a");
				// Validate mobile menu visibility
				if( $(".mobile-menu-list").is(":visible") ){
					// Hide mobile menu
					mobileMenu.slideUp(250);
					// Hide submenus
					submenus.slideUp(250);
					// Remove "open" class from sub toggler
					submenusToggler.removeClass("open");
				}
				else{
					// Show mobile menu
					mobileMenu.slideDown(250);
				}
				// Cancel default event 
				event.preventDefault();
			});
			// Toggle submenu
			var mobileMenuItems = $(".mobile-menu .menu-list .has-sub >a");
			// Add click event to mobile menu items
			mobileMenuItems.click(function(event){
				// Validate for open class
				if( $(this).hasClass("open") ){
					// Remove open class
					$(this).removeClass("open");
				}
				else{
					// Add open class
					$(this).addClass("open");
				}
				// Variables
				var selfSub = $(this).parent(".has-sub"),
					submenu = selfSub.children(".sub");
				// Validate if the mobile menu has sub
				if (submenu.hasClass("sub")) {
					// Validate sub visiblity
					if(submenu.is(":visible")){
						// Hide sub
						submenu.slideUp(250);
					}
					else{
						// Show sub
						submenu.slideDown(250);
					}
					// Prevent events default action
					event.preventDefault();
				}
				else{
					// Do nothing
				}
			});
		},
	
		/**
		 * Starts basic owl carousel
		*/
		basicowlcarousel: function(){
			// Find slider
			$(".basicowlcarousel").each(function(){
				// Init slider
				$(this).owlCarousel({
							"loop":true,
						  	"margin":10,
						  	"autoplay":true,
						  	"autoplayTimeout":7000,
						  	responsive:{
								        0:{
								            items:1
								        },
								        768:{
								            items:1
								        },
								        991:{
								            items:2
								        },
								        992:{
								            items:4
								        }
							}
				});				
			});
		},

		/**
		 * Fetches flickr
		*/
		getFlickr: function(){

			var token = Site.Config.token,
				url = Site.Config.url,
				responseData;

			responseData =  $.ajax({
								url: url+"api/flickr",
								method: "GET",
								headers:{ token:token }
							});
			return responseData;
		},

		/**
		 * Fetches flickr
		*/
		flickrPlugin: function(){
			$(".sb_flickr #loader").fadeIn(250, function(){
				var $flickrRequest = defaultsJs.getFlickr(),
					url = Site.Config.url,
					$fl_tpl, $image;
				$flickrRequest.success(function(data){
						switch(data.status){
							case "error":
								// Hide loader
								$(".sb_flickr #loader").fadeOut(250, function(){
									// Init reload function
									defaultsJs.reloadFlickrPlugin();
								});
							break;
							default:
								for (var i = 0; i < data.data.length; i++) {
									$image = data.data[i];
									$fl_tpl = 	'<div class="col-sm-3 col-xs-4 m-b-10 fgi p-h-5">'+
													'<a href="'+url+'/gallery/'+$image.set+'">'+
														'<img src="https://farm'+$image.farm+'.staticflickr.com/'+$image.server+'/'+$image.id+'_'+$image.secret+'_q.jpg" class="fullwidth radius">'+
													'</a>'+
												'</div>';
									$($fl_tpl).hide().appendTo(".sb_flickr #flickr_photos");
								};
								// Hide loader
								$(".sb_flickr #loader").fadeOut(250, function(){
									$(".sb_flickr #flickr_photos").imagesLoaded(function(){
										var delay = 200;
										// Show photos
										$(".sb_flickr #flickr_photos .fgi").each(function(){
											$(this).delay(delay).fadeIn("fast");
											delay = delay + 50;
										});
									});
								});
							break;
						};
				}).error(function(){
					// Hide loader
					$(".sb_flickr #loader").fadeOut(250, function(){
						// Init reload function
						defaultsJs.reloadFlickrPlugin();
					});
				}).complete(function(){
					// Act on complete
				});
			});
		},

		/**
		 * Reload side bar flickr plugin
		*/
		reloadFlickrPlugin: function(){
			$(".sb_flickr #reload").fadeIn(250, function(){
				$('.sb_flickr #reload #reload-btn').click(function(event){
					$(this).off("click");
					$(".sb_flickr #reload").fadeOut(250, function(){
						defaultsJs.flickrPlugin();
					});
					// Prevent default events
					event.preventDefault();
				});
			});
		},

		/**
		 * Fetches tweet feeds
		*/
		getTweets: function(){
			var token = Site.Config.token,
				url = Site.Config.url, $tw_tpl, $tweet,
				responseData;
			responseData = $.ajax({
				url: url+"api/twitter",
				method: "GET",
				headers:{ token:token }
			});
			return responseData;
		},

		/**
		 * Set up side bar tweet plugin
		*/
		twitterPlugin: function(){
			$(".sb_twitter #loader").fadeIn(250, function(){
				var token = Site.Config.token,
					url = Site.Config.url, $tw_tpl, $tw_ul, $tweet, $usr_tpl,
					$tw_ul = '<ul class="list-unstyled spanned_element p-h-20 oc">';
				$tw_tpl = '<li class="spanned_element p-l-0">'+
							'<div class="spanned_element black m-t-10">|TEXT|</div>'+
							'<div class="spanned_element bold xs-text gray-text text-right m-t-5 m-b-0" data-livestamp="|TIME|"></div>'+
						  '</div>';
				$usr_tpl = '<div class="card spanned_element" style="background:#ddd url(|BANNER|)	0px 0px no-repeat; background-size:cover;">'+
								'<div class="black-background bg-olay">&nbsp;</div>'+
								'<div class="spanned_element p-t-20 p-h-10 p-b-15">'+
									'<div class="container-fluid">'+
										'<div class="row">'+
											'<div class="col-xs-2 nopadding">'+
												'<a href="|URL|" class="no-text-decoration">'+
													'<img src="|IMAGE|" alt="Image" class="pull-left fullwidth" style="border:solid 3px #fff;">'+
												'</a>'+
											'</div>'+
											'<div class="col-xs-10 nopadding">'+
												'<a href="|URL|" class="no-text-decoration">'+
													'<h4 class="spanned_element p-h-10 m-b-0 bold" style="color:|LINKCOLOR|;">|NAME|</h4>'+
													'<h6 class="spanned_element alt-text xs-text m-t-0 p-h-10">|SCREENNAME|</h6>'+
												'</a>'+
											'</div>'+
											'<div class="col-md-12">'+
												'<a href="https://twitter.com/intent/follow?screen_name=|SCREENNAME|" target="_blank"'+
													'class="btn btn-sm white-background hoverable black-link pull-right flat-it p-v-5 bold">'+
													'<i class="twitter-text fa fa-plus"></i>&nbsp;Follow'+
												'</a>'+
											'</div>'+
										'</div>'+
									'<div>'+
								'</div>'+
						   '</div>';
				$tweets = defaultsJs.getTweets();
				$tweets.success(function(data){
					switch (data.status){
						case'error': 
							// Act on error
						break;
						default:
							// Act on success
							var $user = data.data.user;
							// Add user data to view
							$usr_tpl = $usr_tpl.replace("|IMAGE|", $user.photo);
							$usr_tpl = $usr_tpl.replace("|BANNER|", $user.banner);
							$usr_tpl = $usr_tpl.replace("|NAME|", $user.name);
							$usr_tpl = $usr_tpl.replace("|SCREENNAME|", $user.screenName);
							$usr_tpl = $usr_tpl.replace("|SCREENNAME|", $user.screenName);
							$usr_tpl = $usr_tpl.replace("|LINKCOLOR|", "#"+$user.linkColor);
							$usr_tpl = $usr_tpl.replace("|URL|", $user.url);
							$usr_tpl = $usr_tpl.replace("|URL|", $user.url);
							// Loop through tweets
							for (var i = 0;  i <= data.data.tweets.length-1; i++) {
								$tweet = data.data.tweets[i];
								var $tpl = $tw_tpl
								$tpl = $tpl.replace("|TEXT|", $tweet.text);
								$tpl = $tpl.replace("|TIME|", $tweet.time);
								// Update unordered list
								$tw_ul += $tpl;
							};
							$tw_ul += "</ul>";
							// Append tweet list
							$($tw_ul).hide().appendTo(".sb_twitter #tweetSlider");
							$($usr_tpl).hide().appendTo(".sb_twitter #userCard");
							// Init carousel
							$(".sb_twitter #tweetSlider ul.oc").owlCarousel({
								"loop":true,
							  	"margin":0,
							  	"autoplay":true,
							  	"autoplayTimeout":8000,
							  	responsive:{
							        0:{
							            items:1
							        }
						    	}
							});
							// Show slider
							$(".sb_twitter #loader").fadeOut(250, function(){
								$(".sb_twitter #userCard .card").fadeIn(250);
								$(".sb_twitter #tweetSlider ul.oc").fadeIn(250);
							});
						break;
					}
				}).error(function(){
					// Hide loader
					$(".sb_twitter #loader").fadeOut(250, function(){
						// Init reload function
						defaultsJs.reloadTwitterPlugin();
					});
				}).complete(function(){
					// console.log("Tweet request complete");
				});
			});
		},

		/**
		 * Reload side bar tweet plugin
		*/
		reloadTwitterPlugin: function(){
			$(".sb_twitter #reload").fadeIn(250, function(){
				$('.sb_twitter #reload #reload-btn').click(function(event){
					$(this).off("click");
					$(".sb_twitter #reload").fadeOut(250, function(){
						defaultsJs.twitterPlugin();
					});
					// Prevent default events
					event.preventDefault();
				});
			});
		},

		/**
		 * Display/Dismiss my custom modal
		*/
		myModal: function(){
			// Listen for click events on modal toggle buttons
			$('[data-toggle="myModal"]').on("click", function(event){
				// Remove click event litener from toggler, dimisser and overlay
				$('[data-toggle="myModal"]').off("click");
				$('[data-dismiss="myModal"]').off("click");
				$('.myModal-olay').off();
				// Get target
				var target = $(this).attr("data-target");
				defaultsJs.showMyModal(target);
				// Re initiate modal function
				defaultsJs.myModal();
				// Prevent default event
				event.preventDefault();
			});
			// Listen for click event on modal dimisser
			$('[data-dismiss="myModal"]').on("click", function(event){
				// Remove click event litener from toggler, dimisser and overlay
				$('[data-toggle="myModal"]').off("click");
				$('[data-dismiss="myModal"]').off("click");
				$('.myModal-olay').off();
				// Get target
				var target = $(this).parents(".myModal"),
					toggle = $(this).attr("data-toggle"),
					next = $(this).attr("data-target");
				// Validate target
				if (target.hasClass("myModal")) {
					// Remove effect class from modal
					target.removeClass("showMyModal");
					// Hide target
					target.delay(200).fadeOut(200, function(){
						// Check if next modal is set
						if (toggle != undefined && toggle == "nextMyModal") {
							// Make modal visible
							defaultsJs.showMyModal(next);
						}
						else{
							// Make scroll bar visible on body tag
							$("body").removeClass("hide-overflow");
						}
					});
				};
				// Re initiate modal function
				defaultsJs.myModal();
				// Prevent default action
				event.preventDefault();
			});
			// Listen for click event on modal overlay
			$('.myModal-olay').on("click", function(event){
				// Remove click event litener from toggler, dimisser and overlay
				$('[data-toggle="myModal"]').off("click");
				$('[data-dismiss="myModal"]').off("click");
				$('.myModal-olay').off();
				// Get target
				var target = $(this).parents(".myModal");
				// Validate target
				if (target.hasClass("myModal")) {
					// Remove effect class from modal
					target.removeClass("showMyModal");
					// Hide target
					target.delay(200).fadeOut(200, function(){
						// Make scroll bar visible on body tag
						$("body").removeClass("hide-overflow");
					});
				};
				// Re initiate modal function
				defaultsJs.myModal();
				// Prevent default action
				event.preventDefault();
			});
		},

		showMyModal: function(target){
			// Validate target
			if (target != undefined) {
				// Validate target element
				if ($(target).hasClass("myModal")) {
					// Remove scroll bar from body tag
					$("body").addClass("hide-overflow");
					// Show target
					$(target).fadeIn(200, function(){
						// Add class for effect
						$(target).addClass("showMyModal");
					});
				};
			};
		},

		myaccordion: function(){
			// Listen for click event on toggle button
			$("[data-toggle=myaccordion]").click(function(event){
				// Get target and group
				var target = $(this).attr("data-target"),
					group = $(this).attr("data-group");
				// Check if group was defined
				if (group != undefined) {
					// Hide accordions in group
					$("."+group).slideUp("fast");
				};
				// Check if target was defined
				if (target != undefined) {
					if ($(target).hasClass("myaccordion")) {
						// Toggle target visiblity
						if ($(target).is(":visible")) {
							$(target).slideUp("fast");
						}
						else{
							$(target).slideDown("fast");
						}
					};
				};
				// Cancel default action on element
				event.preventDefault();
			});
		},

		/**
		 * functions associated with the footer
		*/
		footer: function(){
		},

		post_card: function(){

			$container = $('#post-card-container')

			$container.imagesLoaded(function(){
			  $container.masonry({
			   	itemSelector: '.post-card-item',
				columnWidth: 0,
				gutterWidth: 0
			  });
			});
		},

		parallaxContent: function(){

			$('[data-parallax="scroll"]').each(function(){

		        var scrollPos;
		        var pagecoverWidth = $(this).height();
		        //opactiy to text starts at 50% scroll length
		        var opacityKeyFrame = pagecoverWidth * 50 / 75;
		        var direction = 'translateX';
		        var speed = 0.17;
		        var $content = $(this).children(".parallaxContent");

		        scrollPos = $(window).scrollTop();
		        direction = 'translateY';

		        $content.css({
		            'transform': direction + '(' + scrollPos * speed + 'px)',
		        });

		        if (scrollPos > opacityKeyFrame) {
		            $content.css({
		                'opacity': 1 - scrollPos / 1200
		            });
		        } else {
		           $content.css({
		                'opacity': 1
		            });
		        }
			});

		},

		pageViews: function(){
			var page = $.parseJSON(Site.data.page);
			// Set data
			var data = {
					 	id:page.id,
					 	name:page.name,
					 	slug:page.slug,
					 	url: keenClient.rsrc.getURL(),
					 	referrer: keenClient.rsrc.getReferrer(),
					 	userAgent: keenClient.rsrc.getUa(),
					 	date: keenClient.rsrc.getDate(),
					 	cookies: keenClient.rsrc.getCookie(),
					};
			// Log data to keen
			// keenClient.addEvent("testPageViews", data);
		},
		
		/**
		 * Listens for window level events 
		 * and calls the required function
		*/
		windowEventsListener: function(){
			// Window scroll event listener
			$(window).scroll(function(){
				// Call sticky nav function
				defaultsJs.parallaxContent();
			});
		},

		init: function(){
			// Load twitter plugin
			defaultsJs.twitterPlugin();
			// Load flickr plugin
			defaultsJs.flickrPlugin();
			// Init window events listener
			defaultsJs.windowEventsListener();
			// Load javascript scroll reveal 
			window.sr = new scrollReveal();
			// Init mobile menu function
			defaultsJs.mobilemenu();
			// Init footer events
			defaultsJs.footer();
			// Init events slider
			defaultsJs.basicowlcarousel();
			// Init Bootstrap datepicker plugin
			$('.datepicker').datepicker({
			    format: 'mm/dd/yyyy'
			});
			defaultsJs.myModal();
			defaultsJs.post_card();
			defaultsJs.myaccordion();
			// Log page view
			defaultsJs.pageViews();
		}
	};
	// Load defaults
	defaultsJs.init();
})();

var waitForFinalEvent = (function () {
  var timers = {};
  return function (callback, ms, uniqueId) {
    if (!uniqueId) {
      uniqueId = "Don't call this twice without a uniqueId";
    }
    if (timers[uniqueId]) {
      clearTimeout (timers[uniqueId]);
    }
    timers[uniqueId] = setTimeout(callback, ms);
  };
})();
// Read a page's GET URL variables and return them as an associative array.
var getUrlVars = (function(){
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
});