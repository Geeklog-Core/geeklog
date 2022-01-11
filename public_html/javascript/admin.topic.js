$(function() {
    var topicimg = $('.admin-topic-image'),
        topicSelector = document.getElementById('admin-topiceditor-parent_id');

    topicimg.mouseover(function() {
        var
        id = $(this).attr('id'),
        obj = $('#' + id),
        src = obj.attr('src'),
        getNaturalSize = function(image) { // get natural image size
            if ('naturalWidth' in image) { // for modern browsers (including IE9)
                return {
                    width:  image.naturalWidth,
                    height: image.naturalHeight
                };
            }
            var img = new Image();
            img.src = image.src;
            return {
                width:  img.width,
                height: img.height
            };
        },
        natural = getNaturalSize(obj[0]),
        top  = -natural.height + 24,
        left = -natural.width  - 2,
        img = '<img src="' + src + '" width="' + natural.width + '"' + ' height="' + natural.height + '" alt="">';

        obj.parent().css('position', 'relative');
        obj.after('<div id="' + id + '-popup" class="admin-topic-image-popup" style="position:absolute;' + 'top:' + top + 'px;left:' + left + 'px;">' + img + '</div>');
    });
    topicimg.mouseout(function() {
        var id = $(this).attr('id');
        $('#' + id + '-popup').remove();
    });

    // Topic editor
    if (topicSelector) {
        // Hide "Hidden" checkbox when the user selects "Root" as parent topic
        topicSelector.addEventListener('change', function (ev) {
            var i,
                elms = document.getElementsByClassName('admin-topiceditor-hidden-element');

            for (i = 0; i < elms.length; i++) {
                elms[i].style.display = (ev.target.selectedIndex === 0) ? 'none':'';
            }
        });
    }
});
