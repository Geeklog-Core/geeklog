function FixHTML( leftblocksID, centerblocksID, rightblocksID ) {
  var ua = navigator.userAgent.toLowerCase();
  var is_old_ie = (ua.indexOf("msie") != -1) && (ua.indexOf("msie 8") == -1) && (ua.indexOf("opera") == -1);

  var leftblocks = document.getElementById(leftblocksID);
  var centerblocks = document.getElementById(centerblocksID);
  var rightblocks = document.getElementById(rightblocksID);



  if ( document.body.getAttribute('class') || document.body.getAttribute('className') ) {
    var classValue = 'left-center-right';

    /* HTMLのid属性の値をチェックします。 */
    if ( leftblocks && centerblocks && !rightblocks ) classValue = 'left-center';
    if ( !leftblocks && centerblocks && rightblocks ) classValue = 'center-right';
    if ( !leftblocks && centerblocks && !rightblocks ) classValue = 'center';

    /* body要素のclass属性に「js_on」を設定します。 */
    classValue += ' js_on';

    /* HTMLの構造によってbody要素のclass属性に値を設定します。 */
    if ( is_old_ie ) {  /* IE7以前用 */
      document.body.setAttribute('className', classValue);
    } else {  /* Gecko, Opera, Safari, IE8他用 */
      document.body.setAttribute('class', classValue);
    }
  }
}
