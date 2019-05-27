/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | Likes Control JavaScript functions                                        |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2019 by the following authors:                              |
// |                                                                           |
// |            Tom Homer - tomhomer AT gmail DOT com                          |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+

$(document).ready(function(){
    // if the user clicks on the like or dislike button
    $(document).on('click', '.gl-like-btn, .gl-dislike-btn', function(event) {
        event.preventDefault(); // Prevent link click from calling likes.php
        
        var item_type = $(this).data('type');
        var item_id = $(this).data('id');
        $clicked_btn = $(this);
        
        // Disable Clicks and mute colors on buttons until finished
        $("#likes-"+item_type+'-'+item_id).attr("style", "opacity:0.2; pointer-events: none;"); 

        // Determine type of like action (what button type pressed)
        if ($clicked_btn.hasClass('gl-like-action')) {
            action = 1; // Like
        } else if($clicked_btn.hasClass('gl-unlike-action')){
            action = 3; // Unlike
        } else if ($clicked_btn.hasClass('gl-dislike-action')) {
            action = 2; // Dislike
        } else if($clicked_btn.hasClass('gl-undislike-action')){
            action = 4; // Undislike
        }

        $.ajax({
            url: 'likes.php',
            type: 'post',
            data: {
                'a': "1",
                'action': action,
                'type': item_type,
                'id': item_id
            },
            beforeSend: function(){
                // Show loading image container
                //$("#likes-loader-"+item_type+'-'+item_id).show();
            },        
            success: function(data){
                res = JSON.parse(data);

                if (res.data_type) {
                    // Notify the user of anything that results in the action not happening
                    $clicked_btn.siblings('span.gl-likes-message').html(''); 
                    alert(res.data);
                } else {
                    // Copy over Likes control with new data
                    $('#likes-'+item_type+'-'+item_id).prop('outerHTML', res.data);
                }
            }, 
            error: function(error){
                console.log("jQuery error message = "+error);    
            },
            complete:function(data){
                // Hide image loading container
                //$("#likes-loader-"+item_type+'-'+item_id).hide();
            }            
        });		

    });

});
