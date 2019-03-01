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
    private $attributes = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->items = array();
        $this->attributes = array();
    }

    /**
     * Create Structured Data Type name
     *
     * @param   string  $type   Usually the plugin of the content used to create the structured data
     * @param   string  $id     Id of content 
     */
    private function create_name($type, $id) 
    {
    
        // Make sure core components are called the same thing
        // If type not recognized then assume plugin
        switch ($type) {
            case "comment":
                break;
            
            case "stories":
            case "story":
                $type = "article";
                break;
                
            case "staticpages":
            case "staticpage":
                $type = "page";
                break;                
        }
    
        $sd_name = $type . '-' . $id;
        
        return $sd_name;
    
    }
    
    /**
     * Add Structured Data Type
     *
     * @param   string  $type       Plugin of the content used to create the structured data
     * @param   string  $id         Id of content 
     * @param   numeric $sd_type    Id of Structured Data Type. See $LANG_structureddatatypes language variable for full list
     * @param   string  $properties Properties for structured data type (type, headline, url, datePublished, dateModified, commentCount, keywords, description)
     * @param   string  $attributes Attributes for structured data item (cache,)
     */
    public function add_type($type, $id, $sd_type, $properties = array(), $attributes = array()) 
    {
        global $_CONF;
        
        // Create structured data name
        $sd_name = $this->create_name($type, $id);
        
        if (isset($attributes['cache']) && $attributes['cache']) {
            $this->attributes[$sd_name]['cache'] = true;
        }
        
        // Remove any empty properties
        foreach($properties as $key => $value) {
            if(empty($value)) 
                unset($properties[$key]);         
        }
        
        // 0 = None
        if ($sd_type > 0 AND $sd_type < 5) {
            $this->items[$sd_name]['@context'] = "https://schema.org";                
            switch ($sd_type) {
                case 1: // WebPage
                    $this->items[$sd_name]['@type'] = "WebPage";
                    break;                
                case 2: // Article
                    $this->items[$sd_name]['@type'] = "Article";
                    break;                
                case 3: // NewsArticle                
                    $this->items[$sd_name]['@type'] = "NewsArticle";
                    break;                
                case 4: // BlogPosting                
                    $this->items[$sd_name]['@type'] = "BlogPosting";
                    break;                
            }
            $this->items[$sd_name]['headline'] = $properties['headline'];
            $this->items[$sd_name]['url'] = $properties['url'];
            $this->items[$sd_name]['datePublished'] = $properties['datePublished'];
            if (isset($properties['dateModified'])) {
                $this->items[$sd_name]['dateModified'] = $properties['dateModified'];
            }
            if (isset($properties['commentCount']) && $properties['commentCount'] > 0) {
                $this->items[$sd_name]['commentCount'] = $properties['commentCount'];
            }
            
            $lang_id = '';
            // See if item supports Geeklog Multi Language support (ie id of item ends in language type  _en) and site Multi Lanugage is enabled
            if (isset($attributes['multi_language']) && $attributes['multi_language'] && COM_isMultiLanguageEnabled()) {
                $lang_id = COM_getLanguageIdForObject($id);
            }
            if (empty($lang_id)) {
                // Assume default language of site
                $lang_id = COM_getLanguageId($_CONF['language_site_default']);
            }
            $this->items[$sd_name]['inLanguage'] = $lang_id;
            
            // keywords // Meta Keywords or Topic List (needs to be a comma delimited list)
            if (isset($properties['keywords'])) {
                $this->items[$sd_name]['keywords'] = $properties['keywords'];
            }            
            
            // Can be set by autotag which can be executed first so do not overwrite if set
            if (isset($properties['description']) && !isset($this->items[$sd_name]['description'])) {
                $this->items[$sd_name]['description'] = $properties['description'];
            }
            
            $this->items[$sd_name]['publisher'] = array(
                "@type"     => "Organization",
                "name" 	    => $_CONF['site_name'],
                "url" 	    => $_CONF['site_url']
            );
            
            if (isset($_CONF['path_site_logo']) && !empty($_CONF['path_site_logo'])) {
                $logo_path = rtrim($_CONF['path_html'], '/') . '/' . ltrim($_CONF['path_site_logo'], '/');
                $sizeAttributes = COM_getImgSizeAttributes($logo_path, false);
                if (is_array($sizeAttributes)) {
                    $logo_url = rtrim($_CONF['site_url'], '/') . '/' . ltrim($_CONF['path_site_logo'], '/');
                    $this->items[$sd_name]['publisher']['logo'] = array(
                        "@type"   => "ImageObject",
                        "url"  => $logo_url,
                        "width"  => $sizeAttributes['width'],
                        "height"  => $sizeAttributes['height']
                    );
                }
            }
            
            /*
            $this->items[$sd_name]['publisher'] = array(
                "@type"     => "Organization",
                "name" 	    => $_CONF['site_name'],
                "url" 	    => $_CONF['site_url'],
                "logo" 		=>         
                    array(
                        "@type"   => "ImageObject",
                        "url"  => $_CONF['site_logo_url'],
                        "width"  => $sizeAttributes['width'],
                        "height"  => $sizeAttributes['height'],
                    ) 
            ); */
            
            $this->items[$sd_name]['mainEntityOfPage'] = array(
                "@type"     => "WebPage",
                "@id" 	=> $properties['url'],
            );
        }
        
    }
    
    /**
	 * Set a property of the structured data item
	 *
     * @param   string  $type       Plugin of the content used to create the structured data
     * @param   string  $id         Id of content 
	 * @param   string $name        Name of property
	 * @param   string $value       Value for property
	 */
	public function set_param_item($type, $id, $name, $value) 
    {
        $sd_name = $this->create_name($type, $id);        
        $this->items[$sd_name][$name] = $value;
	}     
    
    /**
	 * Set a author
	 *
     * @param   string  $type   Plugin of the content used to create the structured data
     * @param   string  $id     Id of content 
	 * @param   string $name
	 */
	public function set_author_item($type, $id, $name) 
    {
        $sd_name = $this->create_name($type, $id);        
        $this->items[$sd_name]['author'] = array(
            "@type"   => "Person",
            "name"  => $name
        );
	}    
    
    /**
	 * Set a image to a type
	 *
     * @param   string  $type   Plugin of the content used to create the structured data
     * @param   string  $id     Id of content 
	 */
	public function set_image_item($type, $id, $url, $width = '', $height = '') 
    {
        $sd_name = $this->create_name($type, $id);        
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
     * @param   string  $type   Plugin of the content used to create the structured data
     * @param   string  $id     Id of content 
     */
    public function add_BreadcrumbList($type, $id)
    {
        $sd_name = $this->create_name($type, $id);        
        $this->items[$sd_name]['@context'] = "https://schema.org";
        $this->items[$sd_name]['@type'] = "BreadcrumbList";
        $this->items[$sd_name]['itemListElement'] = array();
      
        
    }

    /**
	 * Set a breadcrumb for a breadcrumblist 
	 *
     * @param   string  $type       Plugin of the content used to create the structured data
     * @param   string  $id         Id of content 
	 * @param   string $position    Position of breadcrumb
	 * @param   string $id
	 * @param   string $name
	 */
	public function set_breadcrumb_item($type, $id, $position, $item_id, $name) 
    {
        $sd_name = $this->create_name($type, $id);        
        $this->items[$sd_name]['itemListElement'][] = array(
            array(
                "@type"     => "ListItem",
                "position" 	=> $position,
                "item" 		=>         
                    array(
                        "@id"   => $item_id,
                        "name"  => $name,
                    ) 
            )
        );
	}
    
    /**
     * Get Structured Data Cache Instance ID
     *
     * @param   string  $sd_name Name of Structured Data item
     */
    private function get_cacheInstanceID($sd_name) 
    {
        return 'structureddata__' . $sd_name . '__' . CACHE_security_hash();
    }
    
    /**
	 * Retrieve a Cached Structured Data item if it exists 
	 *
     * @param   string  $type       Plugin of the content used to create the structured data
     * @param   string  $id         Id of content 
	 * @param   integer $cache_time Cache time of plugin item in seconds. 0 = disabled, -1 is always
	 */
	public function get_cachedScript($type, $id, $cache_time) 
    {
        $retval = false;
        $sd_name = $this->create_name($type, $id);  
        $cacheInstance = $this->get_cacheInstanceID($sd_name);
        $sd_cache = CACHE_check_instance($cacheInstance, true, true); // Not language or mobile cache specific (as this is ALL topic information)
        if ($sd_cache && $cache_time == -1) {
            $item = unserialize($sd_cache);
            $this->items[$sd_name] = $item;
            
            $retval = true;
        } elseif ($sd_cache && $cache_time > 0) {
            $lu = CACHE_get_instance_update($cacheInstance, true, true);
            $now = time();
            if (($now - $lu) < $cache_time) {
                $item = unserialize($sd_cache);
                $this->items[$sd_name] = $item;
                
                $retval = true;
            }
        }
        
        return $retval;
    }
    
    /**
	 * Delete Structured Data item cache
	 *
     * @param   string  $type       Plugin of the content used to create the structured data
     * @param   string  $id         Id of content 
	 */
	public function clear_cachedScript($type, $id = '') 
    {
        if (!empty($id)){
            $sd_name = $this->create_name($type, $id);
            $cacheInstance = $this->get_cacheInstanceID($sd_name);
        } else {
            // clear all Structured Data cache for a specific type
            $cacheInstance = 'structureddata__'  . $type;
        }
        
        CACHE_remove_instance($cacheInstance);    
    }
    
    /**
     * Returns JSON-LD script of either 1 or all structured data types. Can be included in head or body of webpage
     *
     * @param   string  $type   Plugin of the content used to create the structured data
     * @param   string  $id     Id of content 
     * @return  string
     */
    public function toScript($type = '', $id = '')
    {    
        $script = '';

        if (!empty($type) && !empty($id)) {
            $sd_name = $this->create_name($type, $id);        
        }
        
        if (!empty($sd_name)) {
            // Autotags can insert some structured data variables and may not be setup correctly. Make sure an actual type is set before including
            if (isset($this->items[$sd_name]['@type'])) { 
                $script = '<script type="application/ld+json">' . json_encode($this->items[$sd_name]) . '</script>' . PHP_EOL;
                if (isset($this->attributes[$sd_name]['cache']) && $this->attributes[$sd_name]['cache']) {
                    $cacheInstance = $this->get_cacheInstanceID($sd_name);
                    CACHE_create_instance($cacheInstance, serialize($this->items[$sd_name]), true, true); // Not language or mobile cache specific
                }
                
                // Since requested then remove from array so not added again later to the head
                unset($this->items[$sd_name]);
            }
        } else {  
            foreach ($this->items as $sd_name => $item) {
                if (isset($item['@type'])) {
                    $script .= '<script type="application/ld+json">' . json_encode($item) . '</script>' . PHP_EOL;
                    if (isset($this->attributes[$sd_name]['cache']) && $this->attributes[$sd_name]['cache']) {
                        $cacheInstance = $this->get_cacheInstanceID($sd_name);
                        CACHE_create_instance($cacheInstance, serialize($this->items[$sd_name]), true, true); // Not language or mobile cache specific
                    }
                }
            }        
        }
        
        return $script;
    }

}
