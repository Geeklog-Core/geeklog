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
// $Id: plugin.class.php,v 1.2 2001/11/16 18:39:12 tony_bibbs Exp $

class Plugin {

    // PRIVATE PROPERTIES

    // PUBLIC PROPERTIES
    var $adminlabel;
    var $adminurl;
    var $plugin_name;

    // Search properties
    var $searchlabel;
    var $num_searchresults;
    var $searchheading = array();
    var $searchresults = array();
    var $num_itemssearched; 
    var $num_searchheadings;

    // Submission properties
    var $numsubmissions;
    var $submissionlabel;
    var $submissionhelpfile;
    var $getsumbissionssql;
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
        $adminlabel = '';
        $aadminurl = '';
        $numsubmissions = '';
        $plugin_name = '';
        $searchlabel = '';
        $searchheading = array();
        $num_searchresults = 0;
        $searchresults = array();
        $num_itemssearched = 0;
        $num_searchheadings = 0; 
        $submissionlabel = '';
        $submissionhelpfile = '';
        $getsumbissionssql = '';
        $submissionheading = array();
    }
   
    /**
    * Adds a header that will be used in outputing search results for this
    * plugin
    *
    * @heading      string      Heading label
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
    * @result_string        string      Holds coma delimited set of data
    *
    */
    function addSearchResult($result_string)
    {
        $this->searchresults[$this->num_searchresults] = $result_string;
    }     

    function addSubmissionHeading($heading)
    {
        $this->num_submissions = $this->num_submissions + 1;
        $this->submissionheading[$this->num_submissions] = $heading;
    }
}

?>
