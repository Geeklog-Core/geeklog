/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | Set of javascript functions to support the user-move feature              |
// | where two selectboxes are presented                                       |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2003-2009 by the following authors:                         |
// |                                                                           |
// | Authors:   Matt Kruse  - matt@mattkruse.com                               |
// |            Blaine Lang - blaine@portalparts.com                           |
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


// -------------------------------------------------------------------
// setUsers(select_form)
// Used in the Group Admin function to edit the list of included site members
// Used to set a hidden form variable to the result of all the values in the source selectbox
// -------------------------------------------------------------------
function setUsers(f) { 
	var destVals = new Array(), opt = 0, separator = "|", d = f.fieldTo; 
	while (d[opt]) 
        destVals[opt] = d[opt++].value;
        if(d[opt] > 1) {
            f.groupmembers.value = separator + destVals.join(separator); 
        } else {
            f.groupmembers.value = destVals.join(separator); 
        }
        return true; 
}

// -------------------------------------------------------------------
// sortSelect(select_object)
//   Pass this function a SELECT object and the options will be sorted
//   by their text (display) values
// -------------------------------------------------------------------
function sortSelect(obj) {
    var o = new Array();
    if (obj.options==null) { return; }
    for (var i=0; i<obj.options.length; i++) {
        o[o.length] = new Option( obj.options[i].text, obj.options[i].value, obj.options[i].defaultSelected, obj.options[i].selected) ;
        }
    if (o.length==0) { return; }
    o = o.sort( 
        function(a,b) { 
            if ((a.text+"") < (b.text+"")) { return -1; }
            if ((a.text+"") > (b.text+"")) { return 1; }
            return 0;
            } 
        );

    for (var i=0; i<o.length; i++) {
        obj.options[i] = new Option(o[i].text, o[i].value, o[i].defaultSelected, o[i].selected);
        }
    }

// -------------------------------------------------------------------
// moveSelectedOptions(select_object,select_object[,autosort(true/false)[,regex]])
//  This function moves options between select boxes. Works best with
//  multi-select boxes to create the common Windows control effect.
//  Passes all selected values from the first object to the second
//  object and re-sorts each box.
//  If a third argument of 'false' is passed, then the lists are not
//  sorted after the move.
//  If a fourth string argument is passed, this will function as a
//  Regular Expression to match against the TEXT or the options. If 
//  the text of an option matches the pattern, it will NOT be moved.
//  It will be treated as an unmoveable option.
//  You can also put this into the <SELECT> object as follows:
//    onDblClick="moveSelectedOptions(this,this.form.target)
//  This way, when the user double-clicks on a value in one box, it
//  will be transferred to the other (in browsers that support the 
//  onDblClick() event handler).
// -------------------------------------------------------------------
function moveSelectedOptions(from,to) {
    // Unselect matching options, if required
    if (arguments.length>3) {
        var regex = arguments[3];
        if (regex != "") {
            unSelectMatchingOptions(from,regex);
            }
        }
    // Move them over
    for (var i=0; i<from.options.length; i++) {
        var o = from.options[i];
        if (o.selected) {
            to.options[to.options.length] = new Option( o.text, o.value, false, false);
            }
        }
    // Delete them from original
    for (var i=(from.options.length-1); i>=0; i--) {
        var o = from.options[i];
        if (o.selected) {
            from.options[i] = null;
            }
        }
    if ((arguments.length<3) || (arguments[2]==true)) {
        sortSelect(from);
        sortSelect(to);
        }
    from.selectedIndex = -1;
    to.selectedIndex = -1;
    }
