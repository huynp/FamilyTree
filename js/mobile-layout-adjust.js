
jQuery(document).ready(function () {
	jQuery('#LoginForm').removeClass('hide');
    if (screen.width < 768) {
        // Move social buttons to bottom
        jQuery('#social-links').prependTo('#bottom-bg');
		
		// Move LoginForm to bottom
		jQuery('#LoginForm').appendTo('body');

        // Re-allocate top quick nav menus
        var newMenu = "<div style=\"float: left; vertical-align: bottom; font-size:12px; line-height: 55px; margin-left: 5px;\">";
        newMenu += "<a style=\"color:black\" href=\"/index.php/contact-us\">HELP</a> | "
        newMenu += "<a style=\"color:black\" class=\"open-register-form\" href=\"#LoginForm\" data-toggle=\"modal\">MY ACCOUNT</a>  | ";
        newMenu += "<a style=\"color:black\" href=\"/index.php/login?view=registration\" id=\"v_register\">REGISTER</a>";
        newMenu += "</div>";
        jQuery(newMenu).insertBefore("#search-position");
		
		// Remove menu in top of page after restructure
        jQuery("#top-nav-handler").remove();
		
		// Remove slider
		jQuery("#slideshow-handler-bg").remove();
    }
});
