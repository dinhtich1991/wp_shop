
// Magnific init
jQuery(document).ready(function($){
	"use strict";

	/* Gallery Page init */
	$('.pt-gallery').each( function() {

		$(this).magnificPopup({

		    mainClass: 'mfp-with-fade',
		    removalDelay: 300,
		    delegate: '.quick-view',
		    type: 'image',
		    closeOnContentClick: false,
			closeBtnInside: true,

			image: {
				verticalFit: true,
				titleSrc: function(item) {
					console.log(item.el);
					var img_desc = item.el.parent().parent().find('h3').html();
					return img_desc + '<a class="image-source-link" href="'+item.el.attr('href')+'" target="_blank">source</a>';
				}
	    	},

		    gallery: {
		        enabled:true,
		    },

		    callbacks: {
    			buildControls: function() {
      			// re-appends controls inside the main container
      			this.contentContainer.append(this.arrowLeft.add(this.arrowRight));
    			},
  			},

		});

	});

	/* Single image pop-up init */
	var magnificLink = $('[data-magnific=link]');

	magnificLink.magnificPopup({
		removalDelay: 500,
		type: 'image',
		closeOnContentClick: false,
		closeBtnInside: true,

		callbacks: {
		    beforeOpen: function() {
		    // just a hack that adds mfp-anim class to markup 
		    this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
		    this.st.mainClass = this.st.el.attr('data-effect');
		    }
		},
	});

	/* Single Product Gallery */
	var magnificContainer = $('[data-magnific=container]');

	magnificContainer.each( function() {

		$(this).magnificPopup({

		    mainClass: 'mfp-with-fade',
		    removalDelay: 300,
		    delegate: 'a',
		    type: 'image',
		    closeOnContentClick: false,
			closeBtnInside: true,

			image: {
				verticalFit: true,
				titleSrc: function(item) {
					var img_desc = item.el.attr('title');
					return img_desc + '<a class="image-source-link" href="'+item.el.attr('href')+'" target="_blank">source</a>';
				}
	    	},

		    gallery: {
		        enabled:true,
		    },

		    callbacks: {
    			buildControls: function() {
	      			// re-appends controls inside the main container
	      			if ( this.arrowLeft && this.arrowRight ) {
	      				this.contentContainer.append(this.arrowLeft.add(this.arrowRight));
	      			};
    			},
  			},

		});

	});


	magnificLink.magnificPopup({
		removalDelay: 500,
		type: 'image',
		closeOnContentClick: false,
		closeBtnInside: true,

		callbacks: {
		    beforeOpen: function() {
		    // just a hack that adds mfp-anim class to markup 
		    this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
		    this.st.mainClass = this.st.el.attr('data-effect');
		    }
		},
	});

});