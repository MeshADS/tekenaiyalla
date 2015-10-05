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