<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | plugin.class.php                                                          |
// | Geeklog plugin class.                                                     |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000,2001 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs, tony@tonybibbs.com                                   |
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
//
// $Id: plugin.class.php,v 1.9 2003/05/02 04:04:18 tony Exp $

/**
* This is a poorly thought out class that is used pretty much as a structure when
* we need to pass plugin data back and forth
*
* @author   Tony Bibbs <tony@tonybibbs.com>
*
*/
class Plugin {

    // PRIVATE PROPERTIES

    // PUBLIC PROPERTIES
    var $adminlabel = '';
    var $adminurl = '';
    var $plugin_image = '';
    var $plugin_name = '';

    // Search properties
    var $searchlabel = '';
    var $num_searchresults = 0;
    var $searchheading = array();
    var $searchresults = array();
    var $num_itemssearched = 0; 
    var $num_searchheadings = 0;
    /**
    * @access private
    * @var boolean
    */
    var $_expandedSearchSupport = false;

    // Submission properties
    var $num_submissions = 0;
    var $submissionlabel = '';
    var $submissionhelpfile = '';
    var $getsubmissionssql = '';
    var $submissionheading = array();
    

    // PUBLIC METHODS

    /**
    * Constructor
    *
    * This initializes the plugin
    *
    */
    function Plugin()
    {
        $this->reset();
    }

    /**
    * Resets the object
    *
    */
    function reset()
    {
        $this->adminlabel = '';
        $this->adminurl = '';
        $this->plugin_image = '';
        $this->num_submissions = 0;
        $this->plugin_name = '';
        $this->searchlabel = '';
        $this->searchheading = array();
        $this->num_searchresults = 0;
        $this->searchresults = array();
        $this->num_itemssearched = 0;
        $this->num_searchheadings = 0; 
        $this->submissionlabel = '';
        $this->submissionhelpfile = '';
        $this->getsubmissionssql = '';
        $this->submissionheading = array();
    }
   
    /**
    * Adds a header that will be used in outputing search results for this
    * plugin
    *
    * @param    string      $heading    Heading label
    *
    */ 
    function addSearchHeading($heading)
    {
        $this->num_searchheadings = $this->num_searchheadings + 1;
        $this->searchheading[$this->num_searchheadings] = $heading;
    }

    /**
    * Adds a search result to the result array.
    *
    * @param    string      $result_string      Holds coma delimited set of data
    *
    */
    function addSearchResult($result_string)
    {
        $this->searchresults[] = $result_string;
    }     

    /**
    * Hrm, can't remember what this does exactly
    *
    * @param    string      $heading    string for heading
    *
    */
    function addSubmissionHeading($heading)
    {
        $this->submissionheading[$this->num_submissions] = $heading;
        $this->num_submissions = $this->num_submissions + 1;
    }
    
    /**
    * Sets whether or not the plugin supports expanded search
    * results
    *
    * @author Tony Bibbs <tony AT geeklog DOT net>
    * @access public
    * @param boolean $switch True if expanded search is supported otherwise false
    *
    */
    function setExpandedSearchSupport($switch)
    {
        if (!is_bool($switch)) {
            $switch = false;
        }
        
        $this->_expandedSearchSupport = $switch;
    }
    
    /**
    * Returns if plugin supports expanded searches
    *
    * @author Tony Bibbs <tony AT geeklog DOT net>
    * @access public
    * @return boolean True if expanded search is supported otherwise false
    *
    */
    function supportsExpandedSearch()
    {
        return $this->_expandedSearchSupport;
    }
}

?>