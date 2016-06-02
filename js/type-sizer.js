jQuery(function( $ ){


  //***** type-sizer *****//
  //***** requires jquery.cookie.js *****//
  var storedTextSize = $.cookie('textSizeCookie');

    // set data-type-size attribute of <p> to match attribute stored in cookie
    $('.entry-content p').attr('data-type-size', storedTextSize);

    // mark .selected T
    // if no cookie has been set, lilT gets .selected class
    if ( typeof storedTextSize == "undefined" ) {
      $('a.lilT').addClass('selected');
    }

    else { $('a.'+storedTextSize).addClass('selected');
    }

    $('.tees a').click(function() {
      // set a cookie with the data-type-size attribute of the clicked <a>
      textSize = $(this).attr('data-type-size');
      $.cookie('textSizeCookie', textSize, { expires: 9000, path: '/' } ); //days

      // change data-type-size attribute of <p> to match attribute of clicked <a>
      $('.entry-content p').attr('data-type-size', textSize);

      // mark .selected T
      $('.tees a').removeClass('selected');
      $(this).addClass('selected');
  });

  //**//

});

