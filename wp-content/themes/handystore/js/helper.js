/* Handy Theme js functions ver 1.0 */


/* Star rating update */
jQuery(document).ready(function($){
    $(window).load(function(){
        "use strict";
    		$('p.stars span').replaceWith( '<span><a href="#" class="star-5">5</a><a href="#" class="star-4">4</a><a href="#" class="star-3">3</a><a href="#" class="star-2">2</a><a href="#" class="star-1">1</a></span>' );

    });
});


/* Images Fade in (content builder functionality) */
jQuery(document).ready(function($){
    $(window).load(function(){
        "use strict";
            if ( typeof($.fn.lazyload) == "function" ) {
                $(".image-scroll-fade").lazyload({
                    effect       : "fadeIn"
                }); 
            }
    });
});


/* Adding slider to woocommerce recently-viewed widget */ 
jQuery(document).ready(function($){
    "use strict";
        $('.widget_recently_viewed_products').each(function(){
            var slider = $(this).find('.product_list_widget');
            slider.attr("data-owl","container").attr("data-owl-slides","1").attr("data-owl-type","simple").attr("data-owl-transition","fade").attr("data-owl-navi","true").attr("data-owl-pagi","false");
        });
});


/* Primary navigation animation */
jQuery(document).ready(function($){
    "use strict";
        $('.primary-nav li').has('ul').mouseover(function(){
            $(this).children('ul').css('visibility','visible');
            }).mouseout(function(){
            $(this).children('ul').css('visibility','hidden');
    });

    $('.suppaMenu .suppa_menu_posts').append("<div class=\"sepa\">");
    $('.suppaMenu .suppa_menu_mega_posts').append("<div class=\"sepa\">");

});


/* Extra product gallery images links */
jQuery(document).ready(function($){
    "use strict";
        $("ul.pt-extra-gallery-thumbs li a").on( 'click', function(e) {
            e.preventDefault();
            var mainImage = $(this).attr("href"),
                mainImageContainer = $(this).parent().parent().parent().find(".pt-extra-gallery-img img");
            mainImageContainer.attr({ src: mainImage });
            return false;
        });
});


/* Updating compare add to cart button styles */
jQuery(document).ready(function($){
    "use strict";
        $('table.compare-list .add-to-cart td a').text('Add to Cart').css({
            "height":"34px",
            "line-height":"34px",
            "border-radius":"4px",
            "background":"#c2d44e",
            "padding":"0 15px",
            "margin":"10px 0",
            "color":"#fff",
        });
});


/* To top button */
jQuery(document).ready(function($){
    "use strict";
    // Scroll (in pixels) after which the "To Top" link is shown
    var offset = 300,
        //Scroll (in pixels) after which the "back to top" link opacity is reduced
        offset_opacity = 1200,
        //Duration of the top scrolling animation (in ms)
        scroll_top_duration = 700,
        //Get the "To Top" link
        $back_to_top = $('.to-top');

    //Visible or not "To Top" link
    $(window).scroll(function(){
        ( $(this).scrollTop() > offset ) ? $back_to_top.addClass('top-is-visible') : $back_to_top.removeClass('top-is-visible top-fade-out');
        if( $(this).scrollTop() > offset_opacity ) { 
            $back_to_top.addClass('top-fade-out');
        }
    });

    //Smoothy scroll to top
    $back_to_top.on('click', function(event){
        event.preventDefault();
        $('body,html').animate({
            scrollTop: 0 ,
            }, scroll_top_duration
        );
    });

});


/* Widget Area menu Accordion */
jQuery(document).ready(function($){
    "use strict";
    $('.widget.widget_nav_menu').each(function(){

        var settings = {
                    interval: 100,
                    timeout: 200,
                    over: mousein_triger,
                    out: mouseout_triger
                    };

        $(this).find('.menu-item-has-children').hoverIntent(settings);

        function mousein_triger(){
            var element = $(this);
            element.addClass('open');
            element.children('ul').slideDown();
            element.siblings('li').children('ul').slideUp();
            element.siblings('li').removeClass('open');
            element.siblings('li').find('li').removeClass('open');
            element.siblings('li').find('ul').slideUp();
        }
        function mouseout_triger() {
            var element = $(this);
            element.removeClass('open');
            element.find('li').removeClass('open');
            element.find('ul').slideUp();
        }
    });
});


