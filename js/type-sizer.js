//***** type-size experiment *****//
//***** requires jquery.cookie.js *****//
  var storedTextSize = $.cookie('textSizeCookie');

  // set data-type-size attribute of parent to match attribute stored in cookie
  $('.content-sidebar-wrap').attr('data-type-size', storedTextSize);

  // MARK .SELECTED T
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

    // change data-type-size attribute of parent to match attribute of clicked <a>
    $('.content-sidebar-wrap').attr('data-type-size', textSize);

    // mark .selected T
    $('.tees a').removeClass('selected');
    $(this).addClass('selected');
  });
  //**//
