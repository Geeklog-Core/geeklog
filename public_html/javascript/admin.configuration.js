/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.1                                                               |
// +---------------------------------------------------------------------------+
// | javascript functions to support the online configuration manager          |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2005-2016 by the following authors:                         |
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
            '<div id="tooltip-header"></div>' +
            '<div id="tooltip-content"></div>' +
            '<div id="tooltip-tip"></div>' +
        '</div>'
    );
    $('body').append(tooltipContainer);

    $(document).on('mouseover touchend', '.tooltip', function() {
        var attrHref = glConfigDocUrl;
        var jqobj = $(this);

        var confVar = jqobj.attr('id');

        if ( tooltipHideTimer ) clearTimeout(tooltipHideTimer);

        var pos = jqobj.parent().offset();
        var tabs_pos = $('#tabs').offset();
        var height = jqobj.height();

        tooltipContainer.css({
            left: (tabs_pos.left + 8) + 'px',
            top: (pos.top + height + 5) + 'px',
            width: ($('#tabs').width() - 12) + 'px'
        });

        $.get(attrHref, function(data) {
            if (data.indexOf(confVar) > 0) {
                var a = $(data).find('a[name=' + confVar + ']');
                var ths = a.parent().parent().parent().children("tr:first").children("th");
                var tds = a.parent().parent().children("td");
                var desc = tds.eq(2).html();

                // Changes URI fragment into an absolite URI + fragment
                desc = desc.replace('<a href="spamx.html"', '<a href="' + glConfigDocUrl.substr(0, glConfigDocUrl.lastIndexOf('/')) + '/spamx.html" target="_blank"');
                desc = desc.replace('<a href="#url-rewrite">', '<a href="' + glConfigDocUrl + '#url-rewrite" target="_blank">');
                desc = desc.replace('<a href="#date_formats">', '<a href="' + glConfigDocUrl + '#date_formats" target="_blank">');
                desc = desc.replace('<a href="#Localization">', '<a href="' + glConfigDocUrl + '#Localization" target="_blank">');
                desc = desc.replace('<a href="#desc_advanced_editor">', '<a href="' + glConfigDocUrl + '#desc_advanced_editor" target="_blank">');

                tds.eq(0).children("a").attr('href', attrHref + '#' + confVar);
                tds.eq(0).children("a").attr('target', 'help');
                $('#tooltip-content').html(
                    '<div class="tooltip-block"><div class="tooltip-title">' + ths.eq(0).html() + '</div>' +
                    '<div id="tooltip-variable" class="tooltip-doc">'        + tds.eq(0).html() + '</div></div>' +
                    '<div class="tooltip-block"><div class="tooltip-title">' + ths.eq(1).html() + '</div>' +
                    '<div id="tooltip-default" class="tooltip-doc">'         + tds.eq(1).html() + '</div></div>' +
                    '<div class="tooltip-block"><div class="tooltip-title">' + ths.eq(2).html() + '</div>' +
                    '<div id="tooltip-description" class="tooltip-doc">'     + desc + '</div></div>' +
                    '<a href="javascript:void(0);" id="tooltip-close">X</a>'
                );
            } else {
                $('#tooltip-content').html(
                    '<span>' . geeklog.lang.tooltip_not_found + '</span>'
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

    // click event handler
    $(document.body).click(function(e) {
        var target = $(e.target);

        if ( target.is('input') || target.is('select') || target.is('textarea') ) {
            //var tr = $(target, tabs).parent();
            var tr = target.parent();

            // save changes
            if ( target.attr('id') == 'save_changes' || target.attr('id') == 'form_reset' ) {
                document.subgroup.action = frmGroupAction + '?' + selectedTab.substr(1);
            }

            // change class of currently active row
            if ( tr.hasClass('config_name') ) {
                $('.active-config').removeClass('active-config');
                tr.addClass('active-config');
                target.focus();
            }
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
                        selectedTab = getTabHref();
                    }
                    break;
                }
            }
        }

        // unset action
        if ( target.hasClass('unset_param') ) {
            selectedTab = getTabHref();
            unset(target, target.attr('href').substr(1) );

            e.preventDefault();
            return false;
        }

        // restore action
        if ( target.hasClass('restore_param') ) {
            selectedTab = getTabHref();
            restore(target, target.attr('href').substr(1) );

            e.preventDefault();
            return false;
        }
    });

    /**
     * Get href of active (current) tab
     */
    function getTabHref() {
        var idx = $('#config-tabs > li').index($('.uk-active'));
        return $("#config-tabs > li:eq(" + idx + ") a").attr('href');
    }


    /**
     * Select tab by href
     */
    function selectTab(href, conf) {
        //var foundInTabs = false;

        // first search in ordinary tabs
        $("#config-tabs > li").each(function(idx) {
        
            var a = $('a', this);

            if (a.attr('href') == href) {
                $('#config-tabs > li:eq(' + idx + ')').trigger('click');
                if ( conf ) {
                    selectConf(conf);
                }
                selectedTab = href;

                return true;
            }
        });

        return false;
    }

    function getSelectedConf() {
        var tab = '#' + window.location.search.substr(1);
        var conf = window.location.hash;

        selectTab(tab, conf);
        if ( selectedTab === undefined ) {
            //var idx = tabs.tabs('option', 'active');
            //selectedTab = $("#tabs > ul > li:eq(" + idx + ") a").attr('href');
            selectedTab = getTabHref();
        }
    }

    function selectConf(confName) {
        var conf = $("input[name='" + confName.substr(1) + "[nameholder]" + "']").parent();

        $('.active-config').removeClass('active-config');
        conf.addClass('active-config');
        $("[name='" + confName.substr(1) + "']").focus();
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
        /*
        var tr = $(this).parent().parent();
        var id = '';
        if ( tr.is('tr') ) id = '#' + tr.attr('id');
        */
        document.group.appendChild(tab);
        document.group.appendChild(namev);
        document.group.appendChild(action);
        document.group.action = frmGroupAction + '?' + selectedTab.substr(1) + '#' + param;
        document.group.submit();
    }

    // initialize selected tab
    selectedTab = $("#config-tabs > li:eq(0) a").attr('href');

    // get selected tab and config if passed on url
    getSelectedConf();
});

/**
 * functions to handle element
 */
function handleAdd(self, arr_type, arr_name) {
    var index = "#numeric#"; // numeric index
    if (arr_type.charAt(0) == "*") {
        index = $(self).next("input").val(); // named index
        index = index.replace(/^\s+|\s+$/g, ""); // trim space
        if (index == "") return;
    }
    arr_type = arr_type.substring(1);
    var char = arr_type.charAt(0);
    if (char == "*" || char == "%") {
        add_array(arr_name, index, arr_type);
    } else {
        add_element(arr_name, index, arr_type);
    }
}

function add_array(arr_name, index, arr_type) {
    var new_obj = cloneSkeleton(arr_name);
    new_obj.children("div:first").text(index);
    new_id = "arr_" + arr_name + "_" + index;
    sub_id = arr_name + "[" + index + "]";
    new_obj.children("input.toggle_hidden")
           .attr("onclick", "toggleHidden('" + new_id + "', this);");
    new_obj.children("input[type='hidden']")
           .attr("name", sub_id + "[nameholder]");
    new_obj.children("div.named_config_list")
           .attr("id", new_id);

    var sub1_obj = new_obj.children("div.named_config_list")
                          .children("div.config_name");
    sub1_obj.children("input[name='" + arr_name + "[placeholder][placeholder][nameholder]']")
            .attr("name", sub_id + "[placeholder][nameholder]");
    sub1_obj.children("input[name='" + arr_name + "[placeholder][placeholder]']")
            .attr("name", sub_id + "[placeholder]");

    var sub2_obj = new_obj.children("div.named_config_list")
                          .children("div#add_" + arr_name + "_" + "placeholder");
    sub2_obj.attr("id", "add_" + arr_name + "_" + index);
    sub2_obj.children("input.add_ele_input")
            .attr("onclick", "handleAdd(this, '" + arr_type + "', '" + sub_id + "')");
}

function add_element(arr_name, index, arr_type) {
    var default_value = (arr_type == "text") ? '' : '1';
    if (index == "#numeric#") {
        var new_obj = cloneSkeleton(arr_name);
        if (arr_type != "select") {
            new_obj.children(".opt").attr("value", default_value);
        }
        reindexNumericIndex(arr_name);
    } else {
        arr_id_name = arr_name;
        arr_id_name = arr_id_name.replace("[", "_").replace("]", "");
        var new_obj = cloneSkeleton(arr_id_name);
        new_obj.children("div:first").text(index);
        new_obj.children("input[type='hidden']").attr("name", arr_name + "[" + index + "]" + "[nameholder]");
        new_obj.children(".opt").attr("name", arr_name + "[" + index + "]");
        new_obj.children(".opt").attr("value", default_value);
    }
}

function cloneSkeleton(arr_name) {
    return $("#arr_" + arr_name + " div:first")
            .clone(true)
            .insertBefore("#add_" + arr_name)
            .removeAttr("style"); // remove an attribute: style="display:none;"
}

function reindexNumericIndex(arr_name) {
    var elements = $("#arr_" + arr_name + " div.config_name");
    var length = elements.length;
    elements.each(function() {
        var element = $(this);
        var i = element.index();
        // skip "Add Element" button element and "placeholder" element
        if (i > 0 && i < length - 1) {
            i--;
            element.children("div:first").text(i);
            element.children(".opt").attr("name", arr_name + "[" + i + "]");
        }
    });
}

function gl_cfg_remove(self) {
    var element_div = self.parentNode;
    var elements_div = element_div.parentNode;
    var elements_obj = $(elements_div);
    $(element_div).remove();

    // reindex numerical lists
    if (elements_obj.attr("class") == "numerical_config_list") {
        var arr_name = elements_obj.attr("id");
        arr_name = arr_name.replace(/^arr_/, "");
        reindexNumericIndex(arr_name);
    }
}

function toggleHidden(id, button) {
    $("#" + id).toggle(button.value == '+');
    button.value = (button.value != '+' ? '+' : '-');
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
