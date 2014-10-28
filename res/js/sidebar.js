/**
 * Created by Kupletsky Sergey on 17.10.14.
 *
 * Material Sidebar (Profile menu)
 * Tested on Win8.1 with browsers: Chrome 37, Firefox 32, Opera 25, IE 11, Safari 5.1.7
 * You can use this sidebar in Bootstrap (v3) projects. HTML-markup like Navbar bootstrap component will make your work easier.
 * Dropdown menu and sidebar toggle button works with JQuery and Bootstrap.min.js
 */

RememberScroll.init();

// Sidebar toggle
//
// -------------------
$(document).ready(function() {
    var overlay = $('.sidebar-overlay');

    $('.sidebar-toggle').on('click', function() {
        var sidebar = $('#sidebar');
        sidebar.toggleClass('open');
        if ((sidebar.hasClass('sidebar-fixed-left') || sidebar.hasClass('sidebar-fixed-right')) && sidebar.hasClass('open')) {
            overlay.addClass('active');
        } else {
            overlay.removeClass('active');
        }
    });

    overlay.on('click', function() {
        $(this).removeClass('active');
        $('#sidebar').removeClass('open');
    });

});

// Sidebar constructor
//
// -------------------
$(document).ready(function() {

    var sidebar = $('#sidebar');
    var sidebarHeader = $('#sidebar .sidebar-header');
    var sidebarImg = sidebarHeader.css('background-image');
    var toggleButtons = $('.sidebar-toggle');

    // Hide toggle buttons on default position
    toggleButtons.css('display', 'none');
    $('body').css('display', 'table');

    // Sidebar position
    $('#sidebar-position').change(function() {
        var value = $( this ).val();
        sidebar.removeClass('sidebar-fixed-left sidebar-fixed-right sidebar-stacked').addClass(value).addClass('open');
        if (value == 'sidebar-fixed-left' || value == 'sidebar-fixed-right') {
            $('.sidebar-overlay').addClass('active');
        }
        // Show toggle buttons
        if (value != '') {
            toggleButtons.css('display', 'initial');
            $('body').css('display', 'initial');
        } else {
            // Hide toggle buttons
            toggleButtons.css('display', 'none');
            $('body').css('display', 'table');
        }
    });

    // Sidebar theme
    $('#sidebar-theme').change(function() {
        var value = $( this ).val();
        sidebar.removeClass('sidebar-default sidebar-inverse sidebar-colored sidebar-colored-inverse').addClass(value)
    });

    // Header cover
    $('#sidebar-header').change(function() {
        var value = $(this).val();

        $('.sidebar-header').removeClass('header-cover').addClass(value);

        if (value == 'header-cover') {
            sidebarHeader.css('background-image', sidebarImg)
        } else {
            sidebarHeader.css('background-image', '')
        }
    });
    
    
    //Roberto Novelo: gets the value of data-handler attr and tries to execute the handler.
    $(".sidebar-nav").on("click",".menu-action",function()
	{
		$(".wrapper").children().removeClass('active-section');
		$(this).addClass('active-section');
		callFunctionHandler($(this).data("handler"),$(this).data("section"),window,$(this).data("args"));
		return false;
	});
	
	$(".wrapper").children().hide();
	
	$(".active-section").show();
    
});

/**
 * Created by Kupletsky Sergey on 08.09.14.
 *
 * Add JQuery animation to bootstrap dropdown elements.
 */

(function($) {
    var dropdown = $('.dropdown');

    // Add slidedown animation to dropdown
    dropdown.on('show.bs.dropdown', function(e){
        $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
    });

    // Add slideup animation to dropdown
    dropdown.on('hide.bs.dropdown', function(e){
        $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
    });
    
    
})(jQuery);

jQuery('img[src$=".svg"]').each(function(){
            var $img = jQuery(this);
            var imgID = $img.attr('id');
            var imgClass = $img.attr('class');
            var imgURL = $img.attr('src');

            jQuery.get(imgURL, function(data) {
                // Get the SVG tag, ignore the rest
                var $svg = jQuery(data).find('svg');

                // Add replaced image's ID to the new SVG
                if(typeof imgID !== 'undefined') {
                    $svg = $svg.attr('id', imgID);
                }
                // Add replaced image's classes to the new SVG
                if(typeof imgClass !== 'undefined') {
                    $svg = $svg.attr('class', imgClass+' replaced-svg');
                }

                // Remove any invalid XML tags as per http://validator.w3.org
                $svg = $svg.removeAttr('xmlns:a');

                // Replace image with new SVG
                $img.replaceWith($svg);

            }, 'xml');

        });
    
//Divides namespaced functions in case it is needed. Logs the error in case the handler function is not found.
function callFunctionHandler(functionName, section, context /*, args */) 
{
	var args = [].slice.call(arguments).splice(2);
	var namespaces = functionName.split(".");
	var func = namespaces.pop();
	for(var i = 0; i < namespaces.length; i++) 
	{
		context = context[namespaces[i]];
	}
	try 
	{
		$(".wrapper").children().slideUp('slow');
		$("#"+section).slideDown('slow');
    	return context[func].apply(this, args);
	}
	catch(err) 
	{
	    console.log(err.message);
	}
  
}
    