<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | lib-pdf.php                                                               |
// |                                                                           |
// | Geeklog PDF generator.                                                    |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2004 by the following authors:                              |
// |                                                                           |
// | Authors: Justin Carlson    - justin@w3abode.com                           |
// |          Tony Bibbs        - tony@geeklog.net                             |
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
// $Id: conversion.class.php,v 1.3 2007/11/25 06:59:56 ospiess Exp $

class conversion
{

    /**
    * @var string
    */
    var $html = null;

    /**
    *
    * @author Justin Carlson <justin.carlson@iowa.gov>
    * @access public
    * @param string $content html / text mixed string
    * @return null
    *
    */
    function addHtml($content)
    {
        $this->html = $this->html . $content;
    }

    /**
    *
    * @author Justin Carlson <justin.carlson@iowa.gov>
    * @access public
    * @param formfile , data id
    * @return  mixed
    *
    */
    function convert($opt,$opt2=''){
        global $formloader, $_CONF;

        // Need to use global HTML element
        $file = $this->html;
        if (is_array($file)) {
            $file = implode('',$file);
        }

        preg_match_all("|<\?=(.*?)\?>|U",$file,$out);
        for($i=0; $i < count($out[0]); $i++) {
            eval('$temp=' . $out[1][$i] . ';');
            $file = str_replace($out[0][$i], stripslashes($temp), $file);
        }

        if ($opt == 1) {

            $file=str_replace("=\"","1!ZYOUNK!1",$file);

            $formvert['IEhackedhtml'][1]='/\=(.*?)\>/i';
            $formvert['IEhackedhtml'][2]='="\\1">';
            $file = preg_replace($formvert['IEhackedhtml'][1],$formvert['IEhackedhtml'][2],$file);

            $file=str_replace("=\"","1!ZYOUNK!1",$file);

            $formvert['IEhackedhtml'][1]='/\=(.*?) /i';
            $formvert['IEhackedhtml'][2]='="\\1" ';
            $file = preg_replace($formvert['IEhackedhtml'][1],$formvert['IEhackedhtml'][2],$file);

            $file=str_replace("1!ZYOUNK!1","=\"",$file);

            $formvert['optsel'][1]='/<input(.*)type=\"radio\"(.*)value=\"(.*)\"(.*)(SELECTED|CHECKED)(.*)>(.*)<\/input>/i';
            $formvert['optsel'][2]='<input\\1 type="hidden"\\2 value="\\3"><img src="'.$_CONF['host'].$_CONF['urlpath'].'../images/rchecked.gif"><b>\\7</b>';
            $file = preg_replace($formvert['optsel'][1],$formvert['optsel'][2],$file);

            $formvert['optsel'][1]='/<input(.*)type=\"checkbox\"(.*)value=\"(.*)\"(.*)(SELECTED|CHECKED)(.*)>(.*)<\/input>/i';
            $formvert['optsel'][2]='<input\\1 type="hidden"\\2 value="\\3"><img src="'.$_CONF['host'].$_CONF['urlpath'].'../images/checked.gif"><b>\\7</b>';
            $file = preg_replace($formvert['optsel'][1],$formvert['optsel'][2],$file);

            $formvert['optnonsel'][1]='/<input(.*)type="radio"(.*)value="(.*)"(.*)>(.*)<\/input>/i';
            $formvert['optnonsel'][2]='<img src="'.$_CONF['host'].$_CONF['urlpath'].'../images/runchecked.gif">\\5';
            $file = preg_replace($formvert['optnonsel'][1],$formvert['optnonsel'][2],$file);

            $formvert['optnonsel'][1]='/<input(.*)type="checkbox"(.*)value="(.*)"(.*)>(.*)<\/input>/i';
            $formvert['optnonsel'][2]='<img src="'.$_CONF['host'].$_CONF['urlpath'].'../images/unchecked.gif">\\5';
            $file = preg_replace($formvert['optnonsel'][1],$formvert['optnonsel'][2],$file);

            $formvert['textarea'][1]='/<textarea(.*?)name="(.*?)"(.*?)>(.*?)<\/textarea>/is';
            $formvert['textarea'][2]='<input type="hidden" name="\\2" value="\\4"><table border=1 class="borderon" cellpadding="1"\\3><tr><td idx>\\4</td></tr></table>';
            $file = preg_replace($formvert['textarea'][1],$formvert['textarea'][2],$file);

            $formvert['textarea'][1]='/<select(.*?)name="(.*?)"(.*?)>(.*?)<option value="(.*?)"\ (CHECKED|SELECTED)>(.*?)<\/option>(.*?)<\/select>/is';
            $formvert['textarea'][2]='<input type="hidden" name="\\2" value="\\5">';
            $formvert['textarea'][2].='<table bgcolor="#eeeeee" cellpadding="-1" border="1"><tr><td>';
            $formvert['textarea'][2].='&nbsp;&nbsp;\\7&nbsp;</td><td><img src="'.$_CONF['host'].$_CONF['urlpath'].'../images/selectbox.gif">';
            $formvert['textarea'][2].='</td></tr></table>';
            $file = preg_replace($formvert['textarea'][1],$formvert['textarea'][2],$file);


            $formvert['textarea2'][1]='/<select(.*?)>(.*?)<\/select>/is';
            $formvert['textarea2'][2]='<table bgcolor="#eeeeee" cellpadding="-1" border="1"><tr><td>';
            $formvert['textarea2'][2].='&nbsp;&nbsp;None&nbsp;</td><td><img src="'.$_CONF['host'].$_CONF['urlpath'].'../images/selectbox.gif">';
            $formvert['textarea2'][2].='</td></tr></table>';
            $file = preg_replace($formvert['textarea2'][1],$formvert['textarea2'][2],$file);

            preg_match_all('/<td\ idx>(.*?)<\/td>/is',$file,$matches);
            for($l=0;$l<count($matches[1]);$l++){
                $file=str_replace($matches[1][$l],nl2br($matches[1][$l]),$file);
            }
        }

        $file=str_replace("/>", ">", $file);
        $file=str_replace("/ >", ">", $file);

        if ($opt2 == '1'){
            $file=preg_replace('/<input(.*?)type="submit"(.*?)>/i','',$file);
        } else {
            $formvert['textbox'][1]='/<input(.*?)type="submit"(.*?)value="(.*?)"(.*?)>/i';
            $formvert['textbox'][2]='<table bgcolor="#555555" border="1" class="borderon" cellpadding="1"\\4><tr><td>';
            $formvert['textbox'][2].='<table bgcolor="#eeeeee" border="0" class="borderon" cellpadding="0"\\4><tr><td>\\3</td></tr></table>';
            $formvert['textbox'][2].='</td></tr></table>';
            $file = preg_replace($formvert['textbox'][1],$formvert['textbox'][2],$file);
        }
        return $file;
    }

}

?>
