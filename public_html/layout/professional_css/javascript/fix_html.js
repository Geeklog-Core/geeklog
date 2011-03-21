function FixHTML( leftblocksID, centerblocksID, rightblocksID ) {
  var ua = navigator.userAgent.toLowerCase();
  var is_old_ie = (ua.indexOf("msie") != -1) && (ua.indexOf("msie 8") == -1) && (ua.indexOf("opera") == -1);

  var leftblocks = document.getElementById(leftblocksID);
  var centerblocks = document.getElementById(centerblocksID);
  var rightblocks = document.getElementById(rightblocksID);



  if ( document.body.getAttribute('class') || document.body.getAttribute('className') ) {
    var classValue = 'left-center-right';

    /* Check HTML id attribute. */
    if ( leftblocks && centerblocks && !rightblocks ) classValue = 'left-center';
    if ( !leftblocks && centerblocks && rightblocks ) classValue = 'center-right';
    if ( !leftblocks && centerblocks && !rightblocks ) classValue = 'center';

    /* Set js_on to body class attribute  */
    classValue += ' js_on';

    /* Set body class attribute by HTML structure. */
    if ( is_old_ie ) {  /* IE7, IE6 */
      document.body.setAttribute('className', classValue);
    } else {  /* Gecko, Opera, Safari, IE8 and other */
      document.body.setAttribute('class', classValue);
    }
  }
}
