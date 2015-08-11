jQuery(document).ready(function($) {
	$(".menu-primary").addClass("mobile-menu").before('<div id="mobile-menu-icon"></div>');
	$("#mobile-menu-icon").click(function() {
		$(".mobile-menu").slideToggle();
	});
	$(window).resize(function(){
		if(window.innerWidth > 768) {
			$(".mobile-menu").removeAttr("style");
		}
	});
});