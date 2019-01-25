<?php

// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | structureddata.class.php                                                  |
// |                                                                           |
// | Geeklog Structured Data class.                                            |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2016-2019 by the following authors:                         |
// |                                                                           |
// | Authors: Tom Homer        - tomhomer AT gmail DOT com                     |
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
     * Add Structured Data Type
     *
     * @param   numeric $sd_type     ID of Structured Data Type. See $LANG_structureddatatypes language variable for full list
     * @param   string  $sd_name     Name of structured data item (made up of "plugin_name-plugin_item_id")
     */
    public function add_type($sd_type, $sd_name, $headline, $url, $datePublished, $dateModified, $description)
    {
        switch ($sd_type) {
            case 0: // None
            
                break;
            case 2: // Article
                $this->items[$sd_name]['@context'] = "https://schema.org";
                $this->items[$sd_name]['@type'] = "Article";
                $this->items[$sd_name]['headline'] = $headline;
                $this->items[$sd_name]['url'] = $url;
                $this->items[$sd_name]['datePublished'] = $datePublished;
                $this->items[$sd_name]['datePublished'] = $datePublished;
                $this->items[$sd_name]['dateModified'] = $dateModified;
                if (!isset($this->items[$sd_name]['description'])) {
                    $this->items[$sd_name]['description'] = $description;
                }
                $this->items[$sd_name]['publisher'] = array(
                    "@type"     => "Organization",
                    "name" 	=> "",
                    "logo" 		=>         
                        array(
                            "@type"   => "ImageObject",
                            "url"  => "",
                            "width"  => "",
                            "height"  => "",
                        ) 
                );
                $this->items[$sd_name]['mainEntityOfPage'] = array(
                    "@type"     => "WebPage",
                    "@id" 	=> $url,
                );
            
                break;
        }        
        
    }
    
    /**
	 * Set a parameter of the structured data item
	 *
	 * @param   string $sd_name     Name of structured data item
	 * @param   string $name
	 * @param   string $value
	 */
	public function set_param_item($sd_name, $name, $value) 
    {
        
        $this->items[$sd_name][$name] = $value;

	}     
    
    /**
	 * Set a author
	 *
	 * @param   string $sd_name     Name of structured data item
	 * @param   string $position    Position of breadcrumb
	 * @param   string $id
	 * @param   string $name
	 */
	public function set_author_item($sd_name, $name) 
    {
        
        $this->items[$sd_name]['author'] = array(
            "@type"   => "Person",
            "name"  => $name
        );
        
	}    
    
    /**
	 * Set a image to a type
	 *
	 * @param   string $sd_name     Name of structured data item
	 * @param   string $position    Position of breadcrumb
	 * @param   string $id
	 * @param   string $name
	 */
	public function set_image_item($sd_name, $url, $width, $height) 
    {
        
        $image_item = array(
                "@type"   => "ImageObject",
                "url"  => $url,
        );
        
        if (!empty($width)) {
            $image_item['width'] = $width;
        }
        if (!empty($height)) {
            $image_item['height'] = $height;
        }
        
        $this->items[$sd_name]['image'][] = $image_item;
        
	}
    
    /**
     * Add a breadcrumb list
     *
     * @param string $sd_name
     */
    public function add_BreadcrumbList($sd_name)
    {
        $this->items[$sd_name]['@context'] = "https://schema.org";
        $this->items[$sd_name]['@type'] = "BreadcrumbList";
        $this->items[$sd_name]['itemListElement'] = array();
        
    
    /*
    $schema['@context'] = "https://schema.org";
    $schema['@type'] = "BreadcrumbList";
    $schema['itemListElement'] = array(
            array(
                "@type"     => "ListItem",
                "position" 	=> 1,
                "item" 		=>         
                    array(
                        "@id"   => "https://example.com/dresses",
                        "name"  => "Dresses",
                    ) 
            ),
            array(
                "@type"     => "ListItem",
                "position" 	=> 2,
                "item" 		=>         
                    array(
                        "@id"   => "https://example.com/dresses/real",
                        "name"  => "Real Dresses",
                    ) 
            )                
        );
    echo '<script type="application/ld+json">' . json_encode($schema) . '</script>';
    */        
        
    }

    /**
	 * Set a breadcrumb for a breadcrumblist 
	 *
	 * @param   string $sd_name     Name of breadcrumb list
	 * @param   string $position    Position of breadcrumb
	 * @param   string $id
	 * @param   string $name
	 */
	public function set_breadcrumb_item($sd_name, $position, $id, $name) 
    {
        
        $this->items[$sd_name]['itemListElement'][] = array(
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
     * Returns JSON-LD script of either 1 or all structured data types. Can be included in head or body of webpage
     *
     * @param   string $name
     * @return  string
     */
    public function toScript($sd_name = '')
    {    
        $script = '';
        
        if (!empty($sd_name)) {
            // Autotags can insert some structured data variables and may not be setup correctly. Make sure an actual type is set before including
            if (isset($this->items[$sd_name]['@type'])) { 
                $script = '<script type="application/ld+json">' . json_encode($this->items[$sd_name]) . '</script>' . PHP_EOL;    
            }
        } else {
            foreach ($this->items as $item) {
                if (isset($item['@type'])) {                    
                    $script .= '<script type="application/ld+json">' . json_encode($item) . '</script>' . PHP_EOL;    
                }
            }        
        }
        
        return $script;
    }

}
