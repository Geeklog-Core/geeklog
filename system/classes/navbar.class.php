<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +-------------------------------------------------------------------------+
// | Geeklog 2.2                                                             |
// +-------------------------------------------------------------------------+
// | navbar.class.php                                                        |
// |                                                                         |
// | class to create and display a CSS based Navbar for site navigation      |
// +-------------------------------------------------------------------------+
// | Copyright (C) 2004-2011 by Consult4Hire Inc.                            |
// |                                                                         |
// | Author:                                                                 |
// | Blaine Lang                 -    blaine AT portalparts DOT com          |
// +-------------------------------------------------------------------------+
// |                                                                         |
// | This program is free software; you can redistribute it and/or           |
// | modify it under the terms of the GNU General Public License             |
// | as published by the Free Software Foundation; either version 2          |
// | of the License, or (at your option) any later version.                  |
// |                                                                         |
// | This program is distributed in the hope that it will be useful,         |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of          |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                    |
// | See the GNU General Public License for more details.                    |
// |                                                                         |
// | You should have received a copy of the GNU General Public License       |
// | along with this program; if not, write to the Free Software Foundation, |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.         |
// |                                                                         |
// +-------------------------------------------------------------------------+

/**
 * This class will allow you to setup and generate a CSS Tab Menu and breadcrumb link trail
 * Version 1.1 June 4, 2006
 *
 * @author       Blaine Lang <blaine@portalparts.com>
 */
/* Example Use
    include ($_CONF['path_system'] . 'classes/navbar.class.php');

    $menuItems = array (
        'Site Links' => $_CONF['site_url'] .'/links.php',
        'My Calendar'=> $_CONF['site_url'] .'/calendar.php',
        'Polls'      => $_CONF['site_url'] .'/pollbooth.php'
    );

    $navbar = new navbar;
    $navbar->set_menuItems($menuItems);

    // Add a menu item if user has access
    if (SEC_inGroup('Root')) {
        $navbar->add_menuitem('Admin Home',$_CONF['site_admin_url'] . '/moderation.php');
    }

    // Add a menu item which activates a Javascript function when the onClick event is triggered
    $navbar->add_menuitem('On click test','alert("This works");',true);

    // Add a new menu item which may or may not have a URL to redirect to but also triggers an onClick JS function
    $navbar->add_menuitem('Search Engine','http://www.google.com');
    // Pass in the label to attach the onClick function to
    $navbar->set_onclick('Search Engine','return confirm("Do you want to leave this site?");');

    // Set the current selected tab
    $navbar->set_selected('My Calendar');
    echo $navbar->generate();

    // Generate a breadcrumb trail
    $navbar->openBreadcrumbs();
    $navbar->add_breadcrumbs("{$_CONF['site_url']}/index.php",'home']);

   // Adds just a label, not a link as the last breadcrumb
    $navbar->add_lastBreadcrumb('myplugin');

    // Close and generate the breadcrumb trail
    echo $navbar->closeBreadcrumbs();
*/

class navbar
{
    /**
     * @var array
     */
    private $menuItems = array();

    /**
     * @var string
     */
    private $_selected = '';

    /**
     * @var string
     */
    private $_parms = '';

    /**
     * @var array
     */
    private $_onclick;

    /**
     * @var Template
     */
    private $_bcTemplate = null;    // Template to use for Breadcrumbs

    /**
     * @var int
     */
    private $_numBreadCrumbs = 0;   // Number of Breadcrumb links added

    /**
     * @param $menuItems
     */
    public function set_menuItems($menuItems)
    {
        $this->menuItems = $menuItems;
    }

    /**
     * @param  string $label
     * @param  string $link
     * @param  bool   $onclick
     */
    public function add_menuitem($label, $link, $onclick = false)
    {
        if ($onclick) {
            $this->menuItems[$label] = '#';
            $this->set_onClick($label, $link);
        } else {
            $this->menuItems[$label] = $link;
        }
    }

    /**
     * @param  string $selected
     */
    public function set_selected($selected)
    {
        $this->_selected = $selected;
    }

    /**
     * @param array $params
     */
    public function set_defaultparms($params)
    {
        $this->_parms = $params;
    }

    /**
     * @param  string $item
     * @param  string $option
     */
    public function set_onClick($item, $option)
    {
        $this->_onclick[$item] = $option;
    }

    /**
     * @return string
     */
    public function generate()
    {
        global $_CONF;

        $navTemplate = COM_newTemplate($_CONF['path_layout'] . 'navbar');
        $navTemplate->set_file(array(
            'navbar'   => 'navbar.thtml',
            'menuitem' => 'menuitem.thtml',
        ));

        if ($this->_parms != '') {
            $navTemplate->set_var('parms', $this->_parms);
        }

        foreach ($this->menuItems as $label => $linkUrl) {
            if (is_array($this->_onclick) && array_key_exists($label, $this->_onclick)) {
                $onclick = " onclick='{$this->_onclick[$label]}'";
                $navTemplate->set_var('onclick', $onclick);
                $navTemplate->set_var('link', ($linkUrl == '') ? '#' : $linkUrl);
            } else {
                $navTemplate->set_var('onclick', '');
                $navTemplate->set_var('link', $linkUrl);
            }

            if ($label === $this->_selected) {
                $navTemplate->set_var('cssactive', ' id="active"');
                $navTemplate->set_var('csscurrent', ' id="current"');
            } else {
                $navTemplate->set_var('cssactive', '');
                $navTemplate->set_var('csscurrent', '');
            }
            $navTemplate->set_var('label', $label);
            $navTemplate->parse('menuitems', 'menuitem', true);
        }

        $navTemplate->parse('output', 'navbar');
        $retval = $navTemplate->finish($navTemplate->get_var('output'));

        return $retval;
    }

    public function openBreadcrumbs()
    {
        global $_CONF;

        $this->_bcTemplate = COM_newTemplate($_CONF['path_layout'] . 'navbar');
        $this->_bcTemplate->set_file(array(
            'breadcrumbs' => 'breadcrumbs.thtml',
            'link'        => 'breadcrumb_link.thtml',
        ));
    }

    /**
     * @param  string $url
     * @param  string $label
     * @param  string $title
     */
    public function add_breadcrumbs($url, $label, $title = '')
    {
        if ($this->_numBreadCrumbs == '') {
            $this->_numBreadCrumbs = 0;
        }
        $this->_bcTemplate->set_var('link_url', $url);
        $this->_bcTemplate->set_var('link_label', $label);
        $this->_bcTemplate->set_var('link_title', $title);

        if ($this->_numBreadCrumbs > 0) {
            $this->_bcTemplate->set_var('link_separator', '/&nbsp;');

        } else {
            $this->_bcTemplate->set_var('link_separator', '');
        }

        $this->_bcTemplate->parse('breadcrumb_links', 'link', true);
        $this->_numBreadCrumbs = $this->_numBreadCrumbs + 1;
    }

    /**
     * @param  string $label
     */
    public function add_lastBreadcrumb($label)
    {
        if (trim($label) != '') {
            $label = "/&nbsp;$label";
            $this->_bcTemplate->set_var('last_label', $label);
        }
    }

    /**
     * @return string
     */
    public function closeBreadcrumbs()
    {
        $this->_bcTemplate->parse('output', 'breadcrumbs');

        return $this->_bcTemplate->finish($this->_bcTemplate->get_var('output'));
    }
}
