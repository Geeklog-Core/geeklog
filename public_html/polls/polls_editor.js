// +---------------------------------------------------------------------------+
// | Copyright (C) 2003,2004,2005,2006 by the following authors:               |
// | Version 1.0    Date: Jun 24, 2006                                         |
// | Authors:   Blaine Lang - blaine@portalparts.com                           |
// |                                                                           |
// | Javascript functions for Account Profile Editor                           |
// |                                                                           |
// +---------------------------------------------------------------------------+

function showhidePollsEditorDiv(option,selindex,questions) {
    // Reset the current selected navbar tab
    var navbar = document.getElementById('current');
    if (navbar) navbar.id = '';
    // Cycle thru the navlist child elements - buiding an array of just the link items
    var navbar = document.getElementById('navlist');
    var menuitems = new Array(10);
    var item = 0;
    for (var i=0 ;i < navbar.childNodes.length ; i++ ) {
        if (navbar.childNodes[i].nodeName.toLowerCase() == 'li') {
            menuitems[item] = navbar.childNodes[i];
            item++;
        }
    }
    // Now that I have just the link items I can set the selected tab using the passed selected Item number
    // Set the <a tag to have an id called 'current'
    var menuitem = menuitems[selindex];
    for (var j=0; j<menuitem.childNodes.length; j++ ) {
        if (menuitem.childNodes[j].nodeName.toLowerCase() == 'a')  menuitem.childNodes[j].id = 'current';
    }

    // Reset or show all the main divs - editor tab sections
    for (i=0; i < questions; i++) {
        var div = 'po_' + i;
        if (option != i) {
            document.getElementById(div).style.display = 'none';
        } else {
            document.getElementById(div).style.display = '';
        }
    }
}