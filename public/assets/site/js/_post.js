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