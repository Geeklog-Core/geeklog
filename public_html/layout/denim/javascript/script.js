function FixHTML(leftblocksID, centerblocksID, rightblocksID) {
    var ua = navigator.userAgent.toLowerCase();
    var is_old_ie = (ua.indexOf("msie") != -1) && (ua.indexOf("msie 8") == -1) &&
                    (ua.indexOf("msie 9") == -1) && (ua.indexOf("opera") == -1);
    // Set class attribute name
    // 'class'     for Gecko, Opera, Safari, IE9 and other
    // 'className' for IE8, IE7, IE6
    var classattr = (is_old_ie) ? 'className' : 'class';

    if (document.body.getAttribute(classattr) != '') return;

    var leftblocks   = document.getElementById(leftblocksID);
    var centerblocks = document.getElementById(centerblocksID);
    var rightblocks  = document.getElementById(rightblocksID);

    // Check HTML id attribute
    var classValue = 'left-center-right';
    if (leftblocks  && centerblocks && !rightblocks) classValue = 'left-center';
    if (!leftblocks && centerblocks && rightblocks ) classValue = 'center-right';
    if (!leftblocks && centerblocks && !rightblocks) classValue = 'center';
    
    // Set body class attribute by HTML structure
    document.body.setAttribute(classattr, classValue);
}

function delconfirm() {
  return (confirm("Delete this?")) ? true : false;
}

function postconfirm() {
  return (confirm("Send this?")) ? true : false;
}

$(function() {
  $('#navigation_ul').tinyNav({
    active: 'selected'
  });
  var istouch = ('ontouchstart' in window);
  if (istouch) {
    var obj = $('.block-title');
    $(".block-left-content").css("display", "none");
    $(".block-right-content").css("display", "none");
    obj.live('touchstart', function() {
      this.touched = true;
    });
    obj.live('touchmove', function() {
      this.touchmoved = true;
    });
    obj.live('touchend', function() {
      if (this.touched && !this.touchmoved) {
        $(this).next().toggle();
      }
      this.touched = false;
      this.touchmoved = false;
    });
  }
});
