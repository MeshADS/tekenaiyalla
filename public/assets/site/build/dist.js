var eventJS = new function(){

	var changeCategory = function(){
		$(".category-options").on("change", function(event){
			var selected = $(this).val();
			window.location.href = selected;
		});
	}
	/*
		*Init function for calendar JS
	*/
	this.init = function(){
		changeCategory();	
	};
};

var admissionJS = new function(){

	function loadTeamGallery(){
	    // Init inline Fancybox
	  $(".fancyboxBtn").fancybox({ 
	  	overlay : { locked : false },
	  	autoDimensions:false,
	  	width:560
	  });
	}

	function validateForm(){
	    // Init inline Fancybox
	    if ($("form").hasClass("application-form")) {

	    	$("#application-form").validate({
	    		rules:{
	    			childs_name:{
	    				required:true
	    			},
	    			childs_surname:{
	    				required:true
	    			},
	    			childs_age:{
	    				required:true,
	    				number:true,
	    				min:0
	    			},
	    			childs_sex:{
	    				required:true
	    			},
	    			childs_birthday:{
	    				required:true,
	    				date:true
	    			},
	    			address:{
	    				required:true
	    			},
	    			starting_on:{
	    				required:true,
	    				date:true
	    			},
	    			mothers_name:{
	    				required:true
	    			},
	    			mothers_workphone:{
	    				required:true
	    			},
	    			mothers_homephone:{
	    				required:true
	    			},
	    			mothers_mobilephone:{
	    				required:true
	    			},
	    			mothers_email:{
	    				required:true,
	    				email:true
	    			},
	    			fathers_name:{
	    				required:function(element) {
							        if ($(".application-form #mothers_name").val().length < 1) {
							        	return true;
							        }
							        else{
							        	return false;
							        }
							      }
	    			},
	    			fathers_workphone:{
	    				required:function(element) {
							        if ($(".application-form #mothers_workphone").val().length < 1) {
							        	return true;
							        }
							        else{
							        	return false;
							        }
							      }
	    			},
	    			fathers_homephone:{
	    				required:function(element) {
							        if ($(".application-form #mothers_homephone").val().length < 1) {
							        	return true;
							        }
							        else{
							        	return false;
							        }
							      }
	    			},
	    			fathers_mobilephone:{
	    				required:function(element) {
							        if ($(".application-form #mothers_mobilephone").val().length < 1) {
							        	return true;
							        }
							        else{
							        	return false;
							        }
							      }
	    			},
	    			fathers_email:{
	    				required:function(element) {
							        if ($(".application-form #mothers_email").val().length < 1) {
							        	return true;
							        }
							        else{
							        	return false;
							        }
							      },
	    				email:true
	    			},
	    		},
	    		messages:{
	    			childs_age:{
	    				required:"Age must be a number.",
	    				number:"Age must be a number.",
	    				min:"Child's age must 0 or above."
	    			},
	    			childs_birthday:{
	    				date:"Birthday must be in the following format mm/dd/yyyy."
	    			},
	    			starting_on:{
	    				date:"Starting date must be in the following format mm/dd/yyyy."
	    			},
	    		}
	    	});

	    };
	    // Init inline Fancybox
	    if ($("form").hasClass("afterschool-application-form")) {

	    	$("#afterschool-application-form").validate({
	    		rules:{
	    			childs_name:{
	    				required:true
	    			},
	    			childs_surname:{
	    				required:true
	    			},
	    			childs_sex:{
	    				required:true
	    			},
	    			dob:{
	    				required:true,
	    				date:true
	    			},
	    			address:{
	    				required:true
	    			},
	    			starting_on:{
	    				required:true,
	    				date:true
	    			},
	    			parents_name:{
	    				required:true
	    			},
	    			parents_phone:{
	    				required:true
	    			},
	    			parents_email:{
	    				required:true,
	    				email:true
	    			},
	    			work_address:{
	    				required:true
	    			},
	    			checkboxes:{
	    				required:true,
	    				min:1
	    			}
	    		},
	    		messages:{
	    			dob:{
	    				date:"Birthday must be in the following format mm/dd/yyyy."
	    			},
	    			starting_on:{
	    				date:"Starting date must be in the following format mm/dd/yyyy."
	    			},
	    			checkboxes:{
	    				required:"Please select at least one club to continue.",
	    				min:"Please select at least one club to continue."
	    			},
	    		}
	    	});

	    	var checkedClubs = 0;
	    		checkcheckboxes(checkedClubs);
	    	// Clubs check box
	    	$(".club_checks").click(function(){
				checkedClubs = 0;
	    		checkcheckboxes(checkedClubs);
	    	});

	    };
	}
	function checkcheckboxes(checkedClubs){
		// Update count of checkboxes
		$(".club_checks").each(function(){
			elm = $(this);
			if (elm.is(":checked")) {
				checkedClubs++;
			};
		});
		// Update checkedbox count
		$("#afterschool-application-form .checkboxes").val(checkedClubs);
		// Disable/Enable checkboxes
		$(".club_checks").each(function(){
			elm = $(this);
			if (checkedClubs == 2 && !elm.is(":checked")) {
				elm.prop("disabled", true);
			}
			else{
				elm.prop("disabled", false);
			}
		});
	}
	/*
		Init function for page JS
	*/
	this.init = function(){
			
		loadTeamGallery();
		validateForm();
	};
};
var contactJS = new function(){

	function initializeMap() {

	      	// Define style options
	      	var stylesArray = [
	      		{
	      			featureType:'water',
	      			elementType:'geometry',
	      			 stylers: [
	      			 	{ color:'#fff212' },
	      			 	{ saturation:50 },
				        { lightness:70 },
				        { visibility:"simplified" }
				      ]
	      		},
	      		{
	      			featureType:'road.local',
	      			elementType:'geometry',
	      			 stylers: [
	      			 	{color:'#d28a3e'},
	      			 	{saturation:0},
				        { lightness: 0 }
				      ]
	      		},
	      		{
	      			featureType:'road.arterial',
	      			elementType:'geometry',
	      			 stylers: [
	      			 	{ color:'#d28a3e' },
	      			 	{ saturation:0 },
				        { lightness: 10 }
				      ]
	      		},
	      		{
	      			featureType:'landscape',
	      			elementType:'all',
	      			 stylers: [
	      			 	{color:'#626f3e'},
	      			 	{lightness:0},
				        { visibility: "on" }
				      ]
	      		},
	      		{
	      			featureType:'transit',
	      			elementType:'all',
	      			 stylers: [
				        { visibility: "on" }
				      ]
	      		},
	      		{
	      			featureType:'poi',
	      			elementType:'geometry',
	      			 stylers: [
				        { color: "#626f3e" },
				        { lightness: 0 },
				        { visibility: "on" }
				      ]
	      		},
	      		{
	      			featureType:'administrative',
	      			elementType:'geometry',
	      			 stylers: [
				        { color: "#626f3e" },
				        { lightness: 0 },
				        { visibility: "on" }
				      ]
	      		},
	      		{
	      			featureType:'all',
	      			elementType:'labels.text.fill',
	      			 stylers: [
				        { color: "#ffffff" },
				        { visibility: "on" }
				      ]
	      		},
	      		{
	      			featureType:'all',
	      			elementType:'labels.text.stroke',
	      			 stylers: [
				        { color: "#626f3e" },
				        { visibility: "on" }
				      ]
	      		}
	      	];

	      	// Set info window content
	      	 var contentString = '<div id="content">'+
							      '<div id="siteNotice">'+
							      '</div>'+
							      '<h1 id="firstHeading" class="firstHeading">Acorns And Oaks</h1>'+
							      '<div id="bodyContent">'+
							      '<p>Attribution: Acorns And Oaks, <a href="http://www.acornsandoaks.org" target="_blank">'+
							      'Website</a> </p>'+
							      '</div>'+
							      '</div>';
			// Init info window
			var infowindow = new google.maps.InfoWindow({
				      content: contentString
				});


	      	// Set Lattitude and longitude
	      	var myLatlng = new google.maps.LatLng(4.8007939,7.0360621);

	      	// Set map options
	        var mapOptions = {
	          center: myLatlng,
	          zoom: 16,
	          scrollwheel: false,
	          mapTypeId: google.maps.MapTypeId.ROADMAP
	        };

	        infowindow.setPosition(myLatlng);

	        // Create map with google maps map object
	        var map = new google.maps.Map(document.getElementById('map-canvas'),
	            mapOptions);

	        // Set marker
	        var marker_image = "assets/wcp/img/test/map_marker.png";
	        var marker = new google.maps.Marker({
			      position: myLatlng,
			      icon: marker_image,
			      draggable: false,
			      map: map,
			      title: 'Acorns And Oaks'
			  });

	        // Set map style option
	        map.setOptions({styles: stylesArray});

	        // Set events listener for marker
	        google.maps.event.addListener(marker, "click", function(){

	        	infowindow.open(map,marker);
	        });

	        toggleBounce();

		     // Marker toggle bounce effect
	      	function toggleBounce() {
			  if (marker.getAnimation() != null) {
			    marker.setAnimation(null);
			  } else {
			    marker.setAnimation(google.maps.Animation.BOUNCE);
			  }
			}
	}

	function validateForm () {
		
		$("#contactForm").validate({
			rules:{
				name:{
					required:true
				},
				email:{
					required:true,
					email:true
				},
				comment:{
					required:true
				}
			},
			messages:{
				name:{
					required:"This field is required."
				},
				email:{
					required:"This field is required.",
					email:"Please enter a valid email address."
				},
				comment:{
					required:"This field is required."
				}
			}
		});
	}

	/*
		Init function for page JS
	*/
	this.init = function(){
			validateForm();
		// Init map on window load
    	// google.maps.event.addDomListener(window, 'load', initializeMap);
	};
};
var keenClient = new function(){

	var config = function(){
		var ret = new Keen({
			projectId: "560a6fe196773d0246b5d890",
			writeKey: "e60803c5059df7f58f330506192e8b4c1c12acea1343a350ec2ac5b12b1e5a62e8f3ca6de7b769d30bb6075be8dbe0c566c6b8dee9a78818c6fb2d85dd9d1cea502eaa5639055c63c828424ef866ae816b71b680a159cd8bd2e1140863b6aee9c0c9470fa509a43ade48ecef3cd509fe"
		});

		return ret;
	};

	this.addEvent = function(name, data){
		var response,
			keen = config();

		keen.addEvent(name, data, function(e, r){
			// If failed
			if (e) {
				// Set response to error
				response = e;
			};
			// If successfull
			if (r) {
				// Set response to successful
				response = r
			};
		});
		// return a response
		return response
	};

	this.rsrc =  {
		getCookie: function (){
			//Configure the jQuery cookie plugin to use JSON.
	        $.cookie.json = true;

	        //Set the amount of time a session should last.
	        var sessionExpireTime = new Date();
	        sessionExpireTime.setMinutes(sessionExpireTime.getMinutes()+30);

	        //Check if we have a session cookie:
	        var session_cookie = $.cookie("session_cookie");

	        //If it is undefined, set a new one.
	        if(session_cookie == undefined){
	            $.cookie("session_cookie", {
	                id: Math.uuid()
	            }, {
	                expires: sessionExpireTime,
	                path: "/" //Makes this cookie readable from all pages
	            });
	        }
	        //If it does exist, delete it and set a new one with new expiration time
	        else{
	            $.removeCookie("session_cookie", {
	                path: "/"
	            });
	            $.cookie("session_cookie", session_cookie, {
	                expires: sessionExpireTime,
	                path: "/"
	            });
	        }

	        var permanent_cookie = $.cookie("permanent_cookie");
	        //If it is undefined, set a new one.
	        if(permanent_cookie == undefined){
	            $.cookie("permanent_cookie", {
	                id: Math.uuid()
	            }, {
	                expires: 3650, //10 year expiration date
	                path: "/" //Makes this cookie readable from all pages
	            });
	        }

	        return {
	        	permanent_cookie: permanent_cookie,
	        	session_cookie: session_cookie
	        };
		},

		getURL: function (){
			//Add a pageview event in Keen IO
	        var fullUrl = window.location.href;
	        var parsedUrl = $.url(fullUrl);
	        return {
	                source: parsedUrl.attr("source"),
	                protocol: parsedUrl.attr("protocol"),
	                domain: parsedUrl.attr("host"),
	                port: parsedUrl.attr("port"),
	                path: parsedUrl.attr("path"),
	                anchor: parsedUrl.attr("anchor")
	            };
		},

		getUa: function (){
			var parser = new UAParser();
			return{
	            browser: parser.getBrowser(),
	            engine: parser.getEngine(),
	            os: parser.getOS()
	        };
		},

		getReferrer: function (){
			//Add information about the referrer of the same format as the current page
	        var referrer = document.referrer;
	        referrerObject = null;

	        if(referrer != undefined){
	            parsedReferrer = $.url(referrer);

	            referrerObject = {
	                source: parsedReferrer.attr("source"),
	                protocol: parsedReferrer.attr("protocol"),
	                domain: parsedReferrer.attr("host"),
	                port: parsedReferrer.attr("port"),
	                path: parsedReferrer.attr("path"),
	                anchor: parsedReferrer.attr("anchor")
	            };
	        }
	        return referrerObject;
		},

		getDate: function (){
			// Prep date data
			var d = new Date();
			var shortDay = ["Sun", "Mon", "Tue", "Wed", "Thur", "Fri", "Sat"],
				longDay = ["Sunday", "Monday", "Tueday", "Wednesday", "Thursday", "Friday", "Saturday"],
				shortMonth = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"],
				longMonth = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
				fullYear = d.getFullYear(),
				month = d.getMonth(),
				day = d.getDay(),
				date = d.getDate(),
				hour = d.getHours(),
				minute = d.getMinutes(),
				second = d.getSeconds();
			// Prep data
			var data = {
					date: date,
					day: day,
					shortDay: shortDay[day],
					longDay: longDay[day],
					day: day,
					fullYear: fullYear,
					hour: hour,
					milliseconds: d.getMilliseconds(),
					minute: minute,
					month: month,
					shortMonth: shortMonth[month],
					longMonth: longMonth[month],
					second: second,
					time: d.getTime(),
					dateTime: d.toString(fullYear+'-'+month+'-'+date+' '+hour+":"+minute+":"+second),
					fullDate: month+'-'+date+'-'+fullYear,
				};
			return data;
		}
	};
};
var formJS = new function(){
	var form, elements,
		cc = 0,
		validationRules = [];
		validateOptions = {},
		colors = ["orange", "green", "green2", "purple", "blue"],
		$fieldsetTpl = '<fieldset class="m-b-30">'+
							'|LEGEND|'+
							'<div class="row">'+
								'|ELEMENTS|'+
							'</div>'+
						'</fieldset>',
		$elementTpl = 	'<div class="|SIZE|">'+
							'<div class="form-group">'+
								'|ELEMENT|'+
							'</div>'+										
						'</div>',
		$buttonTpl= '<button type="submit" class="btn btn-lg |COLOR|-background hoverable m-v-40">'+
							'<span class="white-text">Submit</span>'+
					'</button>',
		$elements = [],
		$listValues = [],
		$elements["checkbox"] = '<h4 class="black-text">|ELEMENTNAME|</h4>|OPTIONS|',
		$elements["radio-button"] = '<h4 class="black-text">|ELEMENTNAME|</h4>|OPTIONS|',
		$elements["select"] = 	'<label for="|ELEMENTID|">|ELEMENTNAME|</label>'+
								'<select name="|ELEMENTSLUG|" id="|ELEMENTID|" class="form-control">'+
								'|OPTIONS|'+
								'</select>',
		$elements["text-input"] = 	'<label for="|ELEMENTID|">|ELEMENTNAME|</label>'+
									'<input type="text" name="|ELEMENTSLUG|" id="|ELEMENTID|" class="form-control |IFDATE|">',
		$elements["textarea"] = 	'<label for="|ELEMENTID|">|ELEMENTNAME|</label>'+
									'<textarea name="|ELEMENTSLUG|" id="|ELEMENTID|" rows="3" class="form-control"></textarea>',
		$listValues["select"] = 	'<option value="|OPTIONVALUE|">'+'|OPTIONNAME|'+'</option>',
		$listValues["checkbox"] = 	'<label for="|ELEMENTID|">'+
										'<input type="checkbox" name="|ELEMENTSLUG|[]" id="|ELEMENTID|" value="|OPTIONVALUE|">&nbsp;|ELEMENTNAME|'+
									'</label><br>',
		$listValues["radio-button"] = '<label for="|ELEMENTID|">'+
										'<input type="radio" name="|ELEMENTSLUG|" id="|ELEMENTID|" class="">&nbsp;|ELEMENTNAME|'+
									'</label><br>';

	var bootData = function(){
		form = Site.data.form;
		elements = form.elements;
		formHtml = "";
		for (var i in elements) {
			var group = elements[i];
			var resp = addElementGroups(i, group, $fieldsetTpl);
			formHtml += resp;
		};
		// Append hidden form elements to form
		$(formHtml).appendTo("#"+form.slug+" #form_fields");
		// Create submit button for forms
		var button = $buttonTpl;
		checkCC();
		button = button.replace("|COLOR|", colors[cc]);
		cc++;
		$(button).appendTo("#"+form.slug+" #form_button");
		// Hide form loader
		$(".form_holder .loader").fadeOut('fast', function(){
			// Make form visisible
			$(".form_holder form").fadeIn('fast');
		});
		// Init form plugins
		// Validate form
		validateForm("#"+form.slug);
		// Date picker
		$('.datepicker').datepicker({
		    format: 'mm/dd/yyyy'
		});
	};

	var addElementGroups = function (groupName, group, tpl) {
		checkCC();
		var elements = "";
		if (group.length > 0) {
			tpl = tpl.replace('|LEGEND|', '<legend class="'+colors[cc]+'-text">'+groupName+'</legend>')
			cc++;
		}
		else{
			tpl = tpl.replace('|LEGEND|', '');
		}
		for(var i in group){
			var element = group[i];
		  	elements += creatElement(element);
		};
		tpl = tpl.replace("|ELEMENTS|", elements);
	  	return tpl;
	};

	var creatElement= function(element){
		// Create new checkbox
		var mainTpl = $elementTpl,
		    groupElement = $elements[element.type],
			thisListValues = "",
			listvalues = element.list_values,
			elementRules = element.rules,
			rules = [],
			isDate = false;
		// Loop through rules
		for(var er in elementRules){
			elRule = elementRules[er];
			rules[elRule] = true;
			if (elRule == "date") {
				isDate = true;
			};
		}
		// Loop through list value
		for(var lv in listvalues){
			var listvalue = listvalues[lv];
			thisListValues += $listValues[element.type];
			// Convert elemenet data
			thisListValues = thisListValues.replace("|ELEMENTID|", element.id+listvalue.id);
			thisListValues = thisListValues.replace("|ELEMENTNAME|", listvalue.name);
			thisListValues = thisListValues.replace("|ELEMENTSLUG|", element.slug);
			thisListValues = thisListValues.replace("|OPTIONNAME|", listvalue.name);
			thisListValues = thisListValues.replace("|OPTIONVALUE|", listvalue.value);
			thisListValues = thisListValues.replace("|ELEMENTID|", element.id+listvalue.id);			
		};
		// Set element rules
		validationRules[element.slug] = rules;
		// Format element
		groupElement = groupElement.replace("|OPTIONS|", thisListValues)
		groupElement = groupElement.replace("|ELEMENTNAME|", element.name)
		groupElement = groupElement.replace("|ELEMENTID|", element.id);
		groupElement = groupElement.replace("|ELEMENTID|", element.id);
		groupElement = groupElement.replace("|ELEMENTSLUG|", element.slug);
		if (isDate) {
			groupElement = groupElement.replace("|IFDATE|", 'datepicker');
		};
		// Format element
		mainTpl = mainTpl.replace("|SIZE|", element.size);
		mainTpl = mainTpl.replace("|ELEMENT|", groupElement);
		// Return response
		return mainTpl;
	};

	var validateForm = function(id){

		$(id).validate({
			rules: validationRules
		});
	};

	var checkCC = function(){
		if (cc == colors.length < 1) { cc = 0; };		
	};

	/*
		Init function for page JS
	*/
	this.init = function(){
		bootData();		
	};
};
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
var myaccount = new function(){

	/**
	* Upload and crop user avatar with cropic js
	*/
	function imageUpload(){
		var url = Site.Config.url;
		var user = Site.data.userdata;
		var cropperOptions = {
			modal:true,
			zoomFactor:20,
			rotateControls:false,
			customUploadButtonId:'newAvatarTriger',
			uploadUrl:url+'/api/user/uploadAvatar',
			cropUrl:url+'/api/user/cropAvatar',
			uploadData:{
				"user": user.id,
				"_token": Site.Config.token
			},
			cropData:{
				"user": user.id,
				"_token": Site.Config.token
			},
			onAfterImgCrop: function(data){
				$("#account_avatar").prop("src", url+"/"+data.url);
				resetCroper();
			},
			onError: function(errormsg){
			}
		};
		var cropper = new Croppic('newAvatarCrop', cropperOptions);

		function resetCroper(){
			cropper.reset();
		}
	}
	/**
	* Messages table checkbox actions
	*/
	function checkbox_action () {
		$("#master_checkbox").click(function(event){

			var checked = 0;

			if ($(this).is(":checked")) {

				$(".table_checkbox").prop("checked", true);
				$(".bulk_checked_list").html("");
				$(".table_checkbox").each(function(){
					var item_id = $(this).val();
					$("<input type='hidden' name='list[]' value='"+item_id+"' id='item"+item_id+"'>").prependTo(".bulk_checked_list");
				});
			}
			else{

				$(".table_checkbox").prop("checked", false);
				$(".bulk_checked_list").html("");
			}

			$(".table_checkbox").each(function(){

				if ($(this).is(":checked")) {
					checked ++;
				};

			});

			if (checked > 0) {
				// There are checked
				$(".bulkActionElement").removeClass("hide");
			}
			else{
				// No checked
				if (!$(".bulkActionElement").hasClass("hide")) {
					$(".bulkActionElement").addClass("hide");
				};
			}
			
		});

		$(".table_checkbox").click(function(){

			var item_id = $(this).val(),
				checked = 0;

			if (!$(this).is(":checked")) {

				$("#master_checkbox").prop("checked", false);

				$(".bulk_checked_list #item"+item_id+"").remove();
			}
			else{

				$("<input type='hidden' name='list[]' value='"+item_id+"' id='item"+item_id+"'>").prependTo(".bulk_checked_list");
			}

			$(".table_checkbox").each(function(){

				if ($(this).is(":checked")) {
					checked ++;
				};

			});

			if (checked > 0) {
				// There are checked
				$(".bulkActionElement").removeClass("hide");
			}
			else{
				// No checked
				if (!$(".bulkActionElement").hasClass("hide")) {
					$(".bulkActionElement").addClass("hide");
				};
			}
		});
	}

	/*
	* Init function for page JS
	*/
	this.init = function(){
		imageUpload();
		checkbox_action();		
	};
};
var newsJs = new function(){

	function highlightText(){
	 	var searchQuery = getUrlVars()['search'];
	 	$('.news-list').highlight(searchQuery);
	}

	function reHighlight () {
		$("#news-search").keyup(function(){
			var string = $(this).val();
			$('.news-list').removeHighlight();
			$('.news-list').highlight(string);
		});
	}

	/*
		Init function for page JS
	*/
	this.init = function(){
		highlightText();
		reHighlight();
	};
};
var postJS = new function(){

	/**
	* Gets the current post being viewed
	*/
	var getPost = function(){
		// Get JSON data
		var post = Site.data.post;
		// Return data
		return post;
	};

	/**
	* Sends post analytics to Keen
	*/
	var analytic = function(){
		// Get post
		var post = getPost();
		// Prep analytics data
		var userAgent = keenClient.rsrc.getUa();
		var cookie = keenClient.rsrc.getCookie();
		var referrer = keenClient.rsrc.getReferrer();
		var dateObj = keenClient.rsrc.getDate();
		var url = keenClient.rsrc.getURL();
		var data = {
			id: post.id,
			title: post.title,
			slug: post.slug,
			type: "view",
			referrer: {
				source: referrer.source
			},
			author: {
				id: post.author.id
			},
			category: {
				id: post.category.id
			},
			date: {
				timestamp: dateObj.fullYear+"/"+dateObj.month+"/"+dateObj.date+" "+dateObj.hour+":"+dateObj.minute+":"+dateObj.second,
				date: dateObj.fullDate,
				time: dateObj.hour+":"+dateObj.minute+":"+dateObj.second,
				unixTime: dateObj.time
			}		
		}
		// Add event
		keenClient.addEvent("test.post.activity", data);
	}

	/*
		Init function for page JS
	*/
	this.init = function(){
		analytic();
	};
};
var studentJS = new function(){

	function studentSlider(){
	    // Init inline Fancybox
	  $(".fancyboxBtn").fancybox({ 
	  	overlay : { locked : false },
	  	autoDimensions:false,
	  	width:560
	  });
	}
	/*
		Init function for page JS
	*/
	this.init = function(){
		studentSlider();		
	};
};
var teamJS = new function(){

	function loadTeamGallery(){
	    // Init inline Fancybox
	  $(".teamBioBtn").fancybox({ 
	  	overlay : { locked : false },
	  	autoDimensions:false,
	  	width:560
	  });
	}
	/*
		Init function for page JS
	*/
	this.init = function(){
		loadTeamGallery();		
	};
};
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