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