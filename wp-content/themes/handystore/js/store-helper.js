/* Handy store page js functions ver. 1.0 */

jQuery(document).ready(function($){
    $(window).load(function(){
    	"use strict";
		
		/* List/Grid Switcher */
        $('.pt-view-switcher').on( 'click', 'span', function(e) {
            e.preventDefault();
            if ( (e.currentTarget.className == 'pt-grid active') || (e.currentTarget.className == 'pt-list active') ) {
                return false;
            }
            var iso_container = $('[data-isotope=container]');
            var iso_object = $('[data-isotope=container]').data('isotope');

            iso_container.css({'opacity': '0', 'transition':'none'}).before('<div class="isotope-animation-wrapper"></div>');

            if ( $(this).hasClass('pt-grid') && $(this).not('.active') ) {
                $('.pt-view-switcher .pt-list').removeClass('active');
                $('.pt-view-switcher .pt-grid').addClass('active');
                iso_container.css('overflow', 'visible').find('.isotope-item').each(function(){
                    $(this).removeClass('list-view');
                });
                iso_container.imagesLoaded( function() {
					iso_object.layout();
				});
            }

            if ( $(this).hasClass('pt-list') && $(this).not('.active') ) {
                $('.pt-view-switcher .pt-grid').removeClass('active');
                $('.pt-view-switcher .pt-list').addClass('active');
                iso_container.css('overflow', 'hidden').find('.isotope-item').each(function(){
                    $(this).addClass('list-view');
                    $(this).find('.inner-product-content').css({
						"width": 'auto',
						"height": 'auto',
					});
                });
                iso_container.imagesLoaded( function() {
					iso_object.layout();
				});
            }

            iso_container.isotope( 'on', 'layoutComplete', function() {
                iso_container.css({'opacity':'1', 'transition':'opacity .3s ease-in-out'});
                $(".isotope-animation-wrapper").remove();
            });
        });

		/* Updating isotope container height when using variables */
		$('li.product .variations_form').each(function(){
			var iso_container = $('[data-isotope=container]');
			$(this).on('show_variation', function() {
		 		$(this).find( '.single_variation_wrap' ).stop(true, true).show();
		 		iso_container.isotope('layout');
			});
			$(this).on('hide_variation', function() {
				$(this).find( '.single_variation_wrap' ).hide();
		 			iso_container.isotope('layout');
			});
		});

		/* Product dropdown filters animation */
        var settings = {
            interval: 100,
            timeout: 200,
            over: mousein_triger,
            out: mouseout_triger
        };

        function mousein_triger(){
            $(this).find('.filters-group').css('visibility', 'visible');
            $(this).addClass('hovered');
        }
        function mouseout_triger() {
            $(this).removeClass('hovered');
            $(this).find('.filters-group').delay(300).queue(function() {
                $(this).css('visibility', 'hidden').dequeue();
            });
        }

        $('#filters-sidebar .dropdown-filters').hoverIntent(settings);

		/* Extra product gallery animation */
 		$('li.product .inner-product-content.slide-hover').each(function(){	

	 		var current_product = $(this),
	 			parent = current_product.parent(),
	 			main_image_width = current_product.find('.pt-extra-gallery-img').width(),
				thumbs_width = current_product.find('.pt-extra-gallery-thumbs').outerWidth(),
				buttons_height = current_product.find('.additional-buttons').outerHeight(),
				initial_product_width = current_product.outerWidth(),
				initial_product_height = current_product.outerHeight();

			if ( !parent.hasClass('list-view') ) {
				current_product.css({
					"width": initial_product_width,
					"height": initial_product_height,
				});
				current_product.find('.pt-extra-gallery-img').width(main_image_width);			
			};
 		
 			current_product.hoverIntent({
				sensitivity: 1,   // number = sensitivity threshold (must be 1 or higher)
				interval: 10,     // number = milliseconds of polling interval
				over: function () {
					if ( !parent.hasClass('list-view') ) {
						var new_width = initial_product_width+thumbs_width;
						var new_height = initial_product_height+buttons_height;
						current_product.css({
							"width": new_width,
							"height": new_height,
						});
						current_product.find('.pt-extra-gallery-thumbs').css({'opacity':1});
					};
					parent.css('z-index',20).siblings().css('z-index',10);
				},
				timeout: 0,       // number = milliseconds delay before onMouseOut function call
				out: function () {
					if ( !parent.hasClass('list-view') ) {
						current_product.css({
							"width": initial_product_width,
							"height": initial_product_height,
						});
						current_product.find('.pt-extra-gallery-thumbs').css({'opacity':0});
					};
					parent.css('z-index',11);
				},
			});

 		});

    });
});





