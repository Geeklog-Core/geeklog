<?php

// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | structureddata.class.php                                                          |
// |                                                                           |
// | Geeklog homepage.                                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2016-2017 by the following authors:                         |
// |                                                                           |
// | Authors: Tom Homer                            |
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

/**
 * Class Structured Data
 */
class StructuredData
{
    
    private $items = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->items = array();
    }
    
    
    /**
     * Add a breadcrumb list
     *
     * @param string $name
     */
    public function add_BreadcrumbList($name)
    {
        $this->items[$name]['@context'] = "https://schema.org";
        $this->items[$name]['@type'] = "BreadcrumbList";
        $this->items[$name]['itemListElement'] = array();
    }

    /**
	 * Set a breadcrumb for a breadcrumblist 
	 *
	 * @param   string $breadcrumb  Name of breadcrumb list
	 * @param   string $position    Position of breadcrumb
	 * @param   string $id
	 * @param   string $name
	 */
	public function set_breadcrumb_item($breadcrumb, $position, $id, $name) 
    {
        
        $this->items[$breadcrumb]['itemListElement'][] = array(
            array(
                "@type"     => "ListItem",
                "position" 	=> $position,
                "item" 		=>         
                    array(
                        "@id"   => $id,
                        "name"  => $name,
                    ) 
            )
        );
        
	}
    
    /**
     * Returns JSON-LD script of either 1 or all structured data. Can be included in head or body of webpage
     *
     * @param   string $name
     * @return  string
     */
    public function toScript($name = '')
    {    
        $script = '';
        
        if (!empty($name)) {
            $script = '<script type="application/ld+json">' . json_encode($this->items[$name]) . '</script>' . PHP_EOL;    
        } else {
            foreach ($this->items as $item) {
                $script .= '<script type="application/ld+json">' . json_encode($item) . '</script>' . PHP_EOL;    
            }        
        }
        
        return $script;
    }

}
