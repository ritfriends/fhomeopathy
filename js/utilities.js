jQuery( document ).ready(function() {

	// add submenu icons class in main menu (only for large resolution)
	if (fhomeopathy_IsLargeResolution()) {
	
		jQuery('#navmain > div > ul > li:has("ul")').addClass('level-one-sub-menu');
		jQuery('#navmain > div > ul li ul li:has("ul")').addClass('level-two-sub-menu');										
	}

	jQuery('#navmain > div').on('click', function(e) {

		e.stopPropagation();

		// toggle main menu
		if (fhomeopathy_IsSmallResolution() || fhomeopathy_IsMediumResolution()) {

			var parentOffset = jQuery(this).parent().offset(); 
			
			var relY = e.pageY - parentOffset.top;
		
			if (relY < 36) {
			
				jQuery('ul:first-child', this).toggle(400);
			}
		}
	});

});

function fhomeopathy_IsSmallResolution() {

	return (jQuery(window).width() <= 360);
}

function fhomeopathy_IsMediumResolution() {
	
	var browserWidth = jQuery(window).width();

	return (browserWidth > 360 && browserWidth < 800);
}

function fhomeopathy_IsLargeResolution() {

	return (jQuery(window).width() >= 800);
}

jQuery(document).ready(function () {

  jQuery(window).scroll(function () {
	  if (jQuery(this).scrollTop() > 100) {
		  jQuery('.scrollup').fadeIn();
	  } else {
		  jQuery('.scrollup').fadeOut();
	  }
  });

  jQuery('.scrollup').click(function () {
	  jQuery("html, body").animate({
		  scrollTop: 0
	  }, 600);
	  return false;
  });

});

jQuery(window).scroll(function() {
	if (jQuery(this).scrollTop() > 1){  
		jQuery('#header-main-fixed-container').addClass("header-sticky");
	}
	else{
		jQuery('#header-main-fixed-container').removeClass("header-sticky");
	}
});

function fhomeopathy_setCurrentSlide(slideIndex) {

    var headerMain = jQuery('#header-main-fixed');
    var sliderImageContainer = jQuery('#slider-image-container');

    var slides = headerMain.data('slides');

    if (!slides || slideIndex >= jQuery(slides).length) {

        return;
    }

    var slide = slides[slideIndex];
    var slideImage = 'url("' + slide['slideImage'] + '")';

    if ( slideImage != sliderImageContainer.css('background-image') ) {

        headerMain.css("background-color", '#555555');
        sliderImageContainer.animate({opacity: 0.6}, 400, function() {
                        jQuery(this)
                            .css("background-image", slideImage)
                            .animate({opacity: 1}, 400);
                    });
    }

    jQuery(".slider-dots > span").removeClass("slider-current-dot");

    jQuery(".slider-dots > span:nth-child(" + (slideIndex + 1) + ")").addClass("slider-current-dot");

    headerMain.data('currentslide', slideIndex);
}

jQuery( document ).ready(function() {

    fhomeopathy_setCurrentSlide(0);

    window.sliderPrevNextClicked = false;

    jQuery('.slider-prev').click(function() {

        var currentIndex = jQuery('#header-main-fixed').data('currentslide');

        window.sliderPrevNextClicked = true;

        if (currentIndex > 0) {

            --currentIndex;
            fhomeopathy_setCurrentSlide(currentIndex);

        } else {

            currentIndex = jQuery('#header-main-fixed').data('slides').length - 1;

            fhomeopathy_setCurrentSlide(currentIndex);          
        }
    });

    jQuery('.slider-next').click(function() {

        window.sliderPrevNextClicked = true;
      
        var currentIndex = jQuery('#header-main-fixed').data('currentslide');

        if (currentIndex < jQuery('#header-main-fixed').data('slides').length - 1) {

            ++currentIndex;
            fhomeopathy_setCurrentSlide(currentIndex);

        } else {

            fhomeopathy_setCurrentSlide(0);          
        }
    });

    jQuery('.slider-dots > span').click(function() {

        window.sliderPrevNextClicked = true;

        var slideNum = jQuery(this).data('slidenum');

        fhomeopathy_setCurrentSlide(slideNum);
    });

    window.setInterval(function(){

      if (window.sliderPrevNextClicked) {

        window.sliderPrevNextClicked = false;
        return;
      }
	
		  if ( !jQuery(window).scrollTop() ) {

			  jQuery('.slider-next').click();
		  
	      }
    }, 5000);

    jQuery(document).keydown(function(e) {
        switch(e.which) {
            case 37: // left
            window.sliderPrevNextClicked = true;
            jQuery('.slider-prev').click();
            break;

            case 39: // right
            window.sliderPrevNextClicked = true;
            jQuery('.slider-next').click();
            break;

            default: return;
        }
        e.preventDefault();
    });

});