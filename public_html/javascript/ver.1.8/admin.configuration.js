/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.0                                                               |
// +---------------------------------------------------------------------------+
// | javascript functions to support the online configuration manager          |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2005-2010 by the following authors:                         |
// |                                                                           |
// | Authors: Aaron Blankstein  - kantai AT gmail DOT com                      |
// |          Akeda Bagus       - admin AT gedex DOT web DOT id                |
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

var geeklog;

geeklog = geeklog || {};

// Since jQuery UI v1.10.0, tabs.length(), tabs.add(), tabs.remove(),
// tabs.select(), tabs.show() methods and select event are removed.
geeklog.admin = {
    configuration: {
        getTabLength: function (tabs) {
            return $(tabs).find('li').length;
        },

        addTab: function (tabs, url, text, index) {
            var newItem = $('<li><a href="' + url + '">' + text + '</a></li>');

            if (index <= this.getTabLength(tabs) - 1) {
                newItem.before($(tabs).find('li').eq(index));
            } else {
                newItem.insertAfter($(tabs).find('li').last());
            }

            tabs.tabs('refresh');
        },

        removeTab: function (tabs, index) {
            $(tabs).find('li').eq(index).remove();
            tabs.tabs('refresh');
        }
    }
};

// custom autocomplete with categories
var minLength = 10;
$.widget("custom.search_config", $.ui.autocomplete, {
    _renderMenu: function( ul, items ) {
        var self = this,
            currentCategory = "";

        $.each( items, function( index, item ) {
            if ( index > minLength ) {
                return false;
            } else {
                if ( item.category != currentCategory ) {
                    ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
                    currentCategory = item.category;
                }
                self._renderItemData(ul, item);
            }
        });
    },

    // Since jQuery UI v1.10.0, "item.autocomplete" key of data() is removed.
    //Instead, "ui-autocomplete-item" should be used.
    _renderItemData: function (ul, item) {
        return this._renderItem(ul, item).data('ui-autocomplete-item', item);
    },

    _renderItem: function (ul, item) {
        return $('<li>').append($('<a>').text(item.label)).appendTo(ul);
    }
});

// currently selected tab
var selectedTab;
$(function() {
    // start bootstrap
    var bootstrap = true;
    
    // dropdown menu when tabs overflow
    var dropDown = '';
    // init tabs
    var tabs = $("#tabs").tabs({
        beforeActivate: function(e, ui) {
            if (ui.newTab.children('a').attr('href') === '#tab-dropdown') {
                var container = ui.newTab.parent();
                
                if ($('#tabs-dropdown').length > 0) {
                    $('#tabs-dropdown').toggle();
                } else {
                    ui.newTab.append(dropDown);
                    container.removeClass('ui-tabs-active ui-state-active');
                    
                    // show it and the positioning!
                    $('#tabs-dropdown').show().position({
                        of: ui.newTab,
                        my: 'right top',
                        at: 'right bottom',
                        offset: '0 ' + container.height()
                    });
                }
                
                return false;
            } else {
                $('#tabs-dropdown').hide().parent().removeClass('ui-tabs-active ui-state-active');
                $('.ui-tabs-panel').removeClass('ui-tabs-hide');
            }
            selectedTab = ui.newTab.children('a').attr('href');
        }
    });
    // tabs were getting overflow
    var hiddenTabs = {};
    var dropDownShown = false;
    var lastTabsWidth = 0;
    
    // init autocomplete
    $('#search-configuration').search_config({
        delay: 0,
        source: autocomplete_data,
        focus: function(event, ui) {
            $('#search-configuration').val(ui.item.label);

            return false;
        },
        select: function(event, ui) {
            $('#search-configuration').val(ui.item.label);
            $('#tab-id').val(ui.item.tab_id);
            
            document.group.conf_group.value = ui.item.group;
            document.group.subgroup.value = ui.item.subgroup;
            
            // we need this input for #search-configuration value
            // after submitted
            if ( $(document.group['search-configuration-cached']).length ) {
                $(document.group['search-configuration-cached']).val(ui.item.label);
                $(document.group['tab-id-cached']).val(ui.item.tab_id);
            } else {
                search_label = '<input type="hidden" name="search-configuration-cached" value="'+ui.item.label+'">';
                tab_id = '<input type="hidden" name="tab-id-cached" value="'+ui.item.label+'">';
                $(document.group).append( search_label);
                $(document.group).append( tab_id );
            }
            
            document.group.action = frmGroupAction + '?' + 'tab-' + ui.item.tab_id + '#' + ui.item.value;
            document.group.submit();
            
            return false;
        }
    });
    
    // init help tooltip
    var tooltipCachedPage = '';
    var tooltipHideDelay = 300;
    var tooltipHideTimer = null;
    var tooltipContainer = $(
        '<div id="tooltip-container">' +
            '<div id="tootip-loading"><img src="'+ imgSpinner +'" /> Loading...</div>' +
            '<div id="tooltip-header"></div>' +
            '<div id="tooltip-content"></div>' +
            '<div id="tooltip-tip"></div>' +
        '</div>'
    );
    $('body').append(tooltipContainer);

    $(document).on('mouseover', '.tooltip', function() {
        var attrTarget = $(this).attr('target');
        var attrHref = $(this).attr('href');
        
        if ((attrTarget !== 'help') && !attrHref) return;
        var confVar = attrHref.substr(attrHref.indexOf('#')+1);
        
        if ( tooltipHideTimer ) clearTimeout(tooltipHideTimer);
        
        var pos = $(this).offset();
        var height = $(this).height();
        
        tooltipContainer.css({
            left: pos.left + 'px',
            top: (pos.top + height + 5) + 'px'
        });
        
        $('#tootip-loading').show();
        $.get(attrHref, function(data) {
            $('#tootip-loading').hide();
            if (data.indexOf(confVar) > 0) {
                var a = $(data).find('a[name=' + confVar + ']');
                var row = a.parent().parent().html();
                $('#tooltip-content').html(
                    '<table>' +
                        '<thead><tr>' +
                            '<th>Variable</th>' +
                            '<th>Default Value</th>' +
                            '<th>Description</th>' +
                        '</tr></thead>' +
                    '<tbody>' +
                        row +
                    '</tbody>' +
                    '</table>'
                );
            } else {
                $('#tooltip-content').html(
                    '<span>Help page is not found.</span>'
                )
            }
        });
        
        tooltipContainer.show();
    });
    $(document).on('mouseout', '.tooltip', function() {
        if ( tooltipHideTimer ) clearTimeout(tooltipHideTimer);
        
        tooltipHideTimer = setTimeout(function() {
            tooltipContainer.hide();
        }, tooltipHideDelay);
    });
    $('#tooltip-container').mouseover(function() {
        if ( tooltipHideTimer ) clearTimeout(tooltipHideTimer);
    });
    $('#tooltip-container').mouseout(function() {
        if ( tooltipHideTimer ) clearTimeout(tooltipHideTimer);
        
        tooltipHideTimer = setTimeout(function() {
            tooltipContainer.hide();
        }, tooltipHideDelay);
    });
    $(document).on('click touchout', '#tooltip-close', function() {
        if ( tooltipHideTimer ) clearTimeout(tooltipHideTimer);
        tooltipContainer.hide();
    });

    // check overflow on resize
    $(window).resize(function() {
        tabsOverflowHandler();
    });
    
    // click event handler
    $(document.body).click(function(e) {
        var target = $(e.target);
        var targetParent = target.parent();
        
        if ($('#tabs-dropdown').length > 0) {
            if ((target.attr('class') === 'ui-tabs-anchor') && (target.attr('href') !== '#tab-dropdown')) {
                var idx = tabs.tabs('option', 'active');
                var dummy = idx + ((idx == 0) ? 1 : -1); // dummy is any value not idx
                tabs.tabs("option", "active", dummy);
                tabs.tabs("option", "active", idx);

                $("#tabs-dropdown > li").each(function() {
                    var href = $('a', this).attr('href');
                    $(href).addClass('ui-tabs-hide');
                });
                return false;
            }

            if ( target.is('a') && (target.attr('href') === '#tab-dropdown')) {
//                $('#tabs-dropdown').toggle();
                e.preventDefault();
                return false;
            }
            
            if ((target.attr('id') === 'tabs-dropdown') ||
                    (targetParent.attr('id') === 'tabs-dropdown') ||
                    (targetParent.parent().attr('id') === 'tabs-dropdown' )) {
                return dropDownHandler(e);
            }
        }

        $('#tabs-dropdown').hide();
        $('.config_name', tabs).removeClass('active-config');
        
        if ( target.is('input') || target.is('select') || target.is('textarea') ) {
            var tr = $(target, tabs).parent().parent();
            
            // save changes
            if ( target.attr('id') == 'save_changes' || target.attr('id') == 'form_reset' ) {
                document.subgroup.action = frmGroupAction + '?' + selectedTab.substr(1);
            }
            
            // change class of currently active row
            if ( tr.hasClass('config_name') ) tr.addClass('active-config');
        }
        
        // select config from message box
        if ( target.hasClass('select_config') ) {
            for (key in autocomplete_data ) {
                if ( autocomplete_data[key].value == target.text() && 
                     autocomplete_data[key].group == target.attr('group') &&
                     autocomplete_data[key].subgroup == target.attr('subgroup')) 
                {
                    selectTab( '#tab-' + autocomplete_data[key].tab_id, target.attr('href') );
                    if ( selectedTab === undefined ) {
                        var idx = tabs.tabs('option', 'selected');
                        selectedTab = $("#tabs > ul > li:eq(" + idx + ") a").attr('href');
                    }
                    break;
                }
            }
        }
        
        // unset action
        if ( target.hasClass('unset_param') ) {
            unset(target, target.attr('href').substr(1) );
            
            e.preventDefault();
            return false;
        }
        
        // restore action
        if ( target.hasClass('restore_param') ) {
            restore(target, target.attr('href').substr(1) );
            
            e.preventDefault();
            return false;
        }
    });
    
    // dropdown click
    $(document).on('click', '#tabs-dropdown', function(e) {
        dropDownHandler(e);
    });
    
    function dropDownHandler(e) {
        var target = $(e.target);
        
        if ( target.is('a') || target.is('li')  ) {
            selectTabInHiddenTabs( target.attr('href') );
        }
        
        return false;
    }
    
    /**
     * Select tab by href
     */
    function selectTab(href, conf) {
        var foundInTabs = false;
        
        // first search in ordinary tabs
        $("#tabs > ul > li").each(function(idx) {
            var a = $('a', this);
            
            if (a.attr('href') == href) {
                tabs.tabs('option', 'active', idx);
                if ( conf ) {
                    selectConf(conf);
                }
                selectedTab = href;
                foundInTabs = true;
                
                return true;
            }
        });
        
        // maybe in hiddenTabs
        if ( !foundInTabs ) {
            for (htab in hiddenTabs) {
                if ( htab == href ) {
                    selectTabInHiddenTabs(htab);
                    if ( conf ) {
                        selectConf(conf);
                    }
                    foundInTabs = true;
                }
            }
        }
        
        return foundInTabs
    }
    
    /**
     * Select tab that reside in drop down by href
     */
    function selectTabInHiddenTabs(href) {
        $('.ui-tabs-nav li.ui-state-default').each(function() {
            $(this).removeClass('ui-state-active ui-tabs-active');
//            $(this).attr('aria-selected', false);
//            $(this).attr('tabindex', -1);
        });
        $('.ui-tabs-panel', tabs).addClass('ui-tabs-hide');
        href = href.substring(href.lastIndexOf('#'));
        $( href ).removeClass('ui-tabs-hide');
        $(href).show();
        selectedTab = href;
    }
    
    function getSelectedConf() {
        var tab = '#' + window.location.search.substr(1);
        var conf = window.location.hash;
        
        selectTab(tab, conf);
        if ( selectedTab === undefined ) {
            var idx = tabs.tabs('option', 'active');
            selectedTab = $("#tabs > ul > li:eq(" + idx + ") a").attr('href');
        }
    }
    
    function selectConf(confName) {
        confName = "#config_" + confName.substr(1).replace('[', '_').replace(']', '');
        var conf = $(confName);
        
        conf.addClass('active-config');
    }
    
    function tabsOverflowHandler() {
        var total = getTotalTabsWidth();
        
        $('#tabs-dropdown').hide();
        if ( total.overflowAt !== null ) {
            createDropDownTab(total.overflowAt, total.width);
            lastTabsWidth = tabs.width();
        } else if ( !bootstrap && (tabs.width() > lastTabsWidth) ) {
            var hidden_exists = false;
            for (var k in hiddenTabs) {hidden_exists = true; break;}
            if ( hidden_exists ) {
                reinitDropDownTab();
                lastTabsWidth = tabs.width();
                tabsOverflowHandler();
            }
        }
        
        // select the selected tab
        if ( selectedTab ) {
            selectTab( selectedTab, false );    
        }
    }
    
    function getTotalTabsWidth() {
        var totalWidth = 10;
        var tabsWidth = tabs.width();
        var overflowAt = null;
        
        $("#tabs > ul > li").each(function(idx) {
            totalWidth += ($(this).width() + 5);
            
            if (totalWidth >= tabsWidth && overflowAt === null) {
                overflowAt = idx;
            }
        });
        
        return {'width': totalWidth, 'overflowAt': overflowAt};
    }
    
    function createDropDownTab(idxAfter, totalWidth) {
        var tabsLength = geeklog.admin.configuration.getTabLength(tabs);

        dropDown = '';
        if ( idxAfter > 0 ) {
            idxAfter -= 1;
            
            // remove tabs after the dropdown
            for ( var i = tabsLength-1; i >= idxAfter; i-- ) {
                var currenTab = $('li:eq('+i+') a', tabs);
                
                if ( currenTab.length ) {
                    var currenTabHref = currenTab.attr('href');
                    
                    // when there's a dropdown
                    if ( currenTabHref == '#tab-dropdown' ) {
                        geeklog.admin.configuration.removeTab(tabs, 1);
                    } else {
                        var currenTabContent = $( currenTabHref );
                    
                        hiddenTabs[currenTabHref] = {  
                            'tab_title': currenTab.text(),
                            'tab_content': currenTabContent.html()
                        };
                        
                        geeklog.admin.configuration.removeTab(tabs, i);
                    }
                }
            }
            
            if ( $('a[href=#tab-dropdown]', tabs).length ) {
                geeklog.admin.configuration.removeTab(tabs, geeklog.admin.configuration.getTabLength(tabs) - 1);
            }
            
            for ( tab in hiddenTabs ) {
                dropDown = '<li><a href="' + tab + '">' + 
                            hiddenTabs[tab]['tab_title'] + '</a></li>' + dropDown;
                            
                var tabs_content = '<div id="' + tab.substr(1) + '" ' + 
                                   'class="ui-tabs-panel ui-widget-content ' +
                                   'ui-corner-bottom ui-tabs-hide">' +
                                   hiddenTabs[tab]['tab_content'] +
                                   '</div>';
                
                // append the tab if not exists
                if ( !$(tab).length ) {
                    tabs.append( tabs_content );
                }
            }
            
            if ( dropDown.length ) {
                dropDown = '<ul id="tabs-dropdown" class="ui-widget-content">' + 
                            dropDown + '</ul>';
            }
        }

        dropDownShown = true;
        geeklog.admin.configuration.addTab(tabs, '#tab-dropdown', 'More..', idxAfter);
        dropDownTabIdx  = idxAfter;
    }
    
    function reinitDropDownTab() {
        var tabsLength = geeklog.admin.configuration.getTabLength(tabs);
        
        if ( dropDownShown ) {
            geeklog.admin.configuration.removeTab(tabs, tabsLength - 1);
            dropDownShown = false;
        }
        
        for ( tab in hiddenTabs ) {
            geeklog.admin.configuration.addTab(tabs, tab, hiddenTabs[tab]['tab_title'], tabsLength - 1);
            $( tab ).html( hiddenTabs[tab]['tab_content'] );
        }
        hiddenTabs = {}
        
        var total = getTotalTabsWidth();
        if ( total.overflowAt !== null ) {
            tabsOverflowHandler();
        }
    }
    
    function restore(el, param){
        document.group.subgroup.value = document.subgroup.sub_group.value;
        action = document.createElement("INPUT");
        action.setAttribute("value", "restore");
        action.setAttribute("name", "set_action");
        action.setAttribute("type", "hidden");
        
        namev = document.createElement("INPUT");
        namev.setAttribute("value", param);
        namev.setAttribute("type", "hidden");
        namev.setAttribute("name", "name");
        
        tab = document.createElement("INPUT");
        tab.setAttribute("value", selectedTab.substr(5));
        tab.setAttribute("type", "hidden");
        tab.setAttribute("name", "tab");
        
        document.group.appendChild(tab);
        document.group.appendChild(namev);
        document.group.appendChild(action);
        document.group.action = frmGroupAction + '?' + selectedTab.substr(1) + '#' + param;
        document.group.submit();
    }

    function unset(el, param){
        document.group.subgroup.value = document.subgroup.sub_group.value;
        action = document.createElement("INPUT");
        action.setAttribute("value", "unset");
        action.setAttribute("name", "set_action");
        action.setAttribute("type", "hidden");
        
        namev = document.createElement("INPUT");
        namev.setAttribute("value", param);
        namev.setAttribute("type", "hidden");
        namev.setAttribute("name", "name");
        
        tab = document.createElement("INPUT");
        tab.setAttribute("value", selectedTab.substr(5));
        tab.setAttribute("type", "hidden");
        tab.setAttribute("name", "tab");
        
        // get tr id
        var tr = $(this).parent().parent();
        var id = '';
        if ( tr.is('tr') ) id = '#' + tr.attr('id');
        
        document.group.appendChild(tab);
        document.group.appendChild(namev);
        document.group.appendChild(action);
        document.group.action = frmGroupAction + '?' + selectedTab.substr(1) + '#' + param;
        document.group.submit();
    }
    
    // initialize selected tab
    selectedTab = $("#tabs > ul > li:eq(0) a").attr('href');
    
    // runs overflow handler once in bootstrap
    tabsOverflowHandler();
    
    // get selected tab and config if passed on url
    getSelectedConf();

    // end bootstrap
    bootstrap = false;
});

/**
 * functions to handle element 
 */
function handleAdd(self, array_type, array_name) {
    if (array_type.charAt(0) == "*") {
        handleAddWithName(self, array_type, array_name, self.nextSibling.value);
    } else {
        handleAddWithName(self, array_type, array_name, self.parentNode.parentNode.parentNode.rows.length - 1);
    }
}

function handleAddWithName(self, array_type, array_name, name) {
    array_type = array_type.substring(1);
    if (array_type.charAt(0) == "*" || array_type.charAt(0) == "%") {
        add_array(self.parentNode.parentNode.parentNode, array_name, name, (array_type.charAt(0) == "*"), array_type, '1');
    } else if (array_type == "text") {
        add_element(self.parentNode.parentNode.parentNode, array_name, name, 'text', '', '1');
    } else if (array_type == "placeholder") {
        add_element(self.parentNode.parentNode.parentNode, array_name, name, 'hidden', '1', '1');
    } else if (array_type == "select") {
        add_select(self.parentNode.parentNode.parentNode, array_name, name - 1, '1');
    }
}

function add_select(tbl, arr_name, index, deletable) {
    var newRow = tbl.insertRow(tbl.rows.length - 1);
    titleCell = newRow.insertCell(0);
    paramCell = newRow.insertCell(1);
    titleCell.className = "alignright";
    titleCell.appendChild(document.createTextNode(index));
    dropDown = tbl.getElementsByTagName('tr')[0].getElementsByTagName('td')[1].getElementsByTagName('select')[0].cloneNode(true);
    dropDown.name = arr_name + "[" + index + "]";
    paramCell.appendChild(dropDown);
    
    if (deletable) {
        paramCell.appendChild(document.createTextNode("\n"));
        deleteButton = document.createElement("input");
        deleteButton.type = "button";
        deleteButton.value = "x";
        deleteButton.onclick =
        function(){
            gl_cfg_remove(this)
        };
        paramCell.appendChild(deleteButton);
    }
}

function add_element(tbl, arr_name, index, disp_type, def_val, deletable) {
    var newRow = tbl.insertRow(tbl.rows.length - 1);
    titleCell = newRow.insertCell(0);
    paramCell = newRow.insertCell(1);
    titleCell.className = "alignright";
    titleCell.appendChild(document.createTextNode(index));
    inputBox = document.createElement("input");
    inputBox.type = disp_type;
    inputBox.name = arr_name + "[" + index + "]";
    inputBox.value = def_val;
    paramCell.appendChild(inputBox);
    
    if (deletable) {
        deleteButton = document.createElement("input");
        deleteButton.type = "button";
        deleteButton.value = "x";
        deleteButton.onclick =
        function(){
            gl_cfg_remove(this)
        };
        paramCell.appendChild(deleteButton);
    }
}

function gl_cfg_remove(self) {
    var tableRow = self.parentNode.parentNode;
    var tableBody = tableRow.parentNode;
    var table = tableBody.parentNode;
    var index = 0;
    tableBody.removeChild(tableRow);
    
    // reindex numerical lists
    if (table.className.match(new RegExp('(\\s|^)numerical_config_list(\\s|$)'))) {
        for (var i = 0; i < tableBody.childNodes.length; i += 1) {
            if (tableBody.childNodes[i].tagName == "TR"
                && tableBody.childNodes[i].childNodes[0].childNodes[0].nodeName == "#text") 
            {
                var textNode = tableBody.childNodes[i].childNodes[0].childNodes[0];
                if (!isNaN(parseInt(textNode.nodeValue))) {
                    textNode.nodeValue = '' + index;
                    index += 1;
                }
            }
        }
    }
}

function add_array(tbl, arr_name, arr_index, key_names, arr_type, deletable) {
    var newRow = tbl.insertRow(tbl.rows.length - 1);
    labelCell = newRow.insertCell(0);
    arrayCell = newRow.insertCell(1);

    labelCell.appendChild(document.createTextNode(arr_index));
    labelCell.className = "alignright";

    arrLink = document.createElement("input");
    arrLink.type = "button";
    arrLink.onclick =
    function(){
        hide_show_tbl(selectChildByID(this.parentNode, 'arr_table'), this);
    };
    arrLink.value = "+";
    arrayCell.appendChild(arrLink);

    ele_place_holder = document.createElement("input");
    ele_place_holder.type = "hidden";
    ele_place_holder.name = arr_name + "[" + arr_index + "][placeholder]";
    ele_place_holder.value = "true";
    arrayCell.appendChild(ele_place_holder);

    arrayCell.appendChild(document.createTextNode(" "));

    if (deletable) {
        deleteButton = document.createElement("input");
        deleteButton.type = "button";
        deleteButton.value = "x";
        deleteButton.onclick = function(){
        gl_cfg_remove(this);
        };
        arrayCell.appendChild(deleteButton);
    }

    arrTable = document.createElement("table");
    arrTable.style.display = "none";
    arrTable.id = "arr_table";

    add_ele_cell = arrTable.insertRow(0).insertCell(0);
    add_ele_cell.colspan = 2;
    add_ele_press = document.createElement("input");
    add_ele_press.type = "button";
    add_ele_press.value = "Add Element";
    
    if (! key_names) {
        add_ele_press.onclick = function(){
            handleAdd(this, arr_type, arr_name + "[" + arr_index + "]");
        };
        add_ele_cell.appendChild(add_ele_press);
    } else {
        add_ele_press.onclick = function(){
            handleAdd(this, arr_type, arr_name + "[" + arr_index + "]");
        };
    
        add_ele_cell.appendChild(add_ele_press);
        arr_index_box = document.createElement("input");
        arr_index_box.type = "text";
        arr_index_box.style.width = "65px";
        add_ele_cell.appendChild(arr_index_box);
    }

    arrayCell.appendChild(arrTable);
}

function hide_show_tbl(tbl, button) {
    tbl.style.display = (tbl.style.display != 'none' ? 'none' : '' );
    button.value = (button.value != '+' ? '+' : '-' );
}

function open_group(group_var) {
    document.group.conf_group.value = group_var;
    document.group.submit();
}

function open_subgroup(group_var,sg_var) {
    document.group.conf_group.value = group_var;
    document.group.subgroup.value = sg_var;
    document.group.submit();
}

function selectChildByID(parent, ID) {
    for(i=0; i < parent.childNodes.length; i++){
        child = parent.childNodes[i];
        if (child.id == ID) {
            return child;
        }
    }
}
