jQuery(function( $ ){

    $('.home-featured .wrap') .css({'height': (($(window).height()))+'px'});
    $(window).resize(function(){
        $('.home-featured .wrap') .css({'height': (($(window).height()))+'px'});
    });

    $(".home-featured .home-widgets-1 .widget:last-child").after('<p class="arrow"><a href="#home-widgets"></a></p>');

    $.localScroll({
    	duration: 750
    });

    // Set #relationships p.entry-content to same height
    var heights = $('#relationships p.entry-content').map(function(){
        return $(this).height();
    }).get();

    maxHeight = Math.max.apply(null, heights);
    $('#relationships p.entry-content').css('height', maxHeight);

    /*
    $(window).scroll(function () {
      if ($(document).scrollTop() > 1 ) {
        $('.site-header').addClass('shrink');
      } else {
        $('.site-header').removeClass('shrink');
      }
    });
    /**/

});