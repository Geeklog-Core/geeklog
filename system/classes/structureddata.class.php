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
    private $types = array(); // Defined Structured Data types
    private $items = array();
    private $attributes = array();

    // Constants for property in the types array
    // These are public but cannot specify as this for constants since it is support in PHP 7.1 and higher
    const SCHEMA_PROPERTY = '0';
    const SCHEMA_PROPERTY_REQUIRED = '1';
    const SCHEMA_PROPERTY_TYPE = '@type';
    const SCHEMA_PROPERTY_TYPE_REPEAT = '@type-repeat';
    const SCHEMA_PROPERTY_inLanguage = 'inLanguage';
    const SCHEMA_TYPE_publisher = 'publisher';
    const SCHEMA_TYPE_mainEntityOfPage = 'mainEntityOfPage';
    //const SCHEMA_PROPERTY_author = 'author';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->items = array();
        $this->attributes = array();

        // Build Available Structured Data Types
        // Core Structure Data Types available to all
        // Name of structured data type should be "plugin-structureddatatype"

        /*
        // Code for testing the SCHEMA_PROPERTY_TYPE_REPEAT option in the structured data class
        // core-review and core-product are incomplete and is just meant for testing
        $name = 'core-review';
        $this->types[$name]['@type'] = 'Review';
        $this->types[$name]['name']['property'] = $this::SCHEMA_PROPERTY_REQUIRED;
        $this->types[$name]['reviewBody']['property'] = $this::SCHEMA_PROPERTY_REQUIRED;

        $name = 'core-product';
        $this->types[$name]['@type'] = 'Product';
        $this->types[$name]['name']['property'] = $this::SCHEMA_PROPERTY_REQUIRED;
        $this->types[$name]['review']['property'] = $this::SCHEMA_PROPERTY_TYPE_REPEAT;
        $this->types[$name]['review']['value'] = 'core-review'; // Uses a sub type so specify id
        $this->types[$name]['datePublished']['property'] = $this::SCHEMA_PROPERTY_REQUIRED;

        // Code below For testing SCHEMA_PROPERTY_TYPE_REPEAT should be placed in staticpage temporarily functions.inc file when in use
        // Shows how to handle repeating types properties within structured data
        $properties['name'] = 'Some Product Name';
        $properties['datePublished'] = "2019-10-22";
        $properties['review'][] = array(
                "name"   => "Widget Review",
                "reviewBody"  => "This is the body of the widget review"
        );
        $properties['review'][] = array(
                "name"   => "Device Review",
                "reviewBody"  => "This is the body of the device review"
        );

        $attributes['multi_language'] = true;
        // Since staticpage can be cached and autotags within content may insert structured data properties need to cache structured data info as well.
        if (($cache_time > 0 || $cache_time == -1) AND !$draft_flag) {
            $attributes['cache'] = true;
        }
        $_STRUCT_DATA->add_type('staticpages', $sp_id, 'core-product', $properties, $attributes);
        */



        // core-blog is currently not being used but is planed for the home and topic pages
        /*
        $name = 'core-blog';
        $this->types[$name]['@type'] = 'Blog';
        $this->types[$name]['blogPost']['property'] = $this::SCHEMA_PROPERTY_TYPE_REPEAT;
        $this->types[$name]['blogPost']['value'] = 'core-blogposting'; // Uses a sub type so specify id
        */

        $name = 'core-author';
        $this->types[$name]['@type'] = 'Person';
        $this->types[$name]['name']['property'] = $this::SCHEMA_PROPERTY_REQUIRED;
        $this->types[$name]['url']['property'] = $this::SCHEMA_PROPERTY;

        // These next structure types all share the same properties
        $sd_types = array(
            'core-webpage',
            'core-article',
            'core-newsarticle',
            'core-blogposting'
        );
        foreach ($sd_types as $name) {
            switch ($name) {
                case 'core-webpage':
                    $this->types[$name]['@type'] = 'WebPage';
                    break;
                case 'core-article':
                    $this->types[$name]['@type'] = 'Article';
                    break;
                case 'core-newsarticle':
                    $this->types[$name]['@type'] = 'NewsArticle';
                    break;
                case 'core-blogposting':
                    $this->types[$name]['@type'] = 'BlogPosting';
                    break;

            }
            $this->types[$name]['headline']['property'] = $this::SCHEMA_PROPERTY_REQUIRED;
            $this->types[$name]['url']['property'] = $this::SCHEMA_PROPERTY_REQUIRED;
            $this->types[$name]['datePublished']['property'] = $this::SCHEMA_PROPERTY_REQUIRED;
            $this->types[$name]['dateModified']['property'] = $this::SCHEMA_PROPERTY;
            $this->types[$name]['commentCount']['property'] = $this::SCHEMA_PROPERTY;
            $this->types[$name]['inLanguage']['property'] = $this::SCHEMA_PROPERTY_inLanguage;  // inLanguage Property is built into Geeklog
            $this->types[$name]['keywords']['property'] = $this::SCHEMA_PROPERTY;
            $this->types[$name]['description']['property'] = $this::SCHEMA_PROPERTY;
            $this->types[$name]['publisher']['property'] = $this::SCHEMA_TYPE_publisher; // Publisher Type is built into Geeklog
            $this->types[$name]['mainEntityOfPage']['property'] = $this::SCHEMA_TYPE_mainEntityOfPage; // mainEntityOfPage Type is built into Geeklog
            $this->types[$name]['author']['property'] = $this::SCHEMA_PROPERTY_TYPE;
            $this->types[$name]['author']['value'] = 'core-author'; // Uses a sub type so specify id
        }
    }

    /**
     * Load Plugin specific Structured Data Types
     */
    public function load_plugin_types()
    {
        $plugin_structureddatatypes = PLG_getStructuredDataTypes();
        if (is_array($plugin_structureddatatypes)) {
            $this->types = array_merge($this->types, $plugin_structureddatatypes);
        }
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
     * @param   string  $sd_type    Id of Structured Data Type. See $LANG_structureddatatypes language variable for full list
     * @param   string  $properties Properties for structured data type (type, headline, url, datePublished, dateModified, commentCount, keywords, description)
     * @param   string  $attributes Attributes for structured data item (cache, multi language)
     * @param   array   $data is the subset of data that will need to be set for the structured data (passed by reference). if null then full array will be used
     */
    public function add_type($type, $id, $sd_type, $properties = array(), $attributes = array(), &$data = null)
    {
        global $_CONF, $LANG_ISO639_1;

        // Create structured data name
        $sd_name = $this->create_name($type, $id);

        if (isset($attributes['cache']) && $attributes['cache']) {
            $this->attributes[$sd_name]['cache'] = true;
        }

        // See if structured data type has been defined
        if (isset($this->types[$sd_type])) {
            if ($data === null) {
                // Use the entire array element for the structured data name
                $data = &$this->items[$sd_name];
                $data_subset = false;
            } else {
                // Use the passed in array which is a subset of the entire array element for the structured data name
                // Used for when you have types within types
                $data_subset = true;
            }

            foreach($this->types[$sd_type] as $i => $item) {
                if ($i == '@type') {
                    if (!$data_subset) {
                        $data['@context'] = "https://schema.org";
                    }
                    $data[$i] = $item;
                } else{
                    switch ($item['property']) {
                        case $this::SCHEMA_PROPERTY:
                        case $this::SCHEMA_PROPERTY_REQUIRED:
                            // Can be set by autotag which can be executed first so do not overwrite if set
                            if (isset($properties[$i]) && !isset($data[$i])) {
                                $data[$i] = $properties[$i];
                            }

                            if ($item['property'] == $this::SCHEMA_PROPERTY_REQUIRED AND !isset($data[$i])) {
                                $data[$i] = '';
                            }
                            break;

                        case $this::SCHEMA_PROPERTY_inLanguage:
                            $lang_id = '';
                            // See if item supports Geeklog Multi Language support (ie id of item ends in language type  _en) and site Multi Lanugage is enabled
                            if (isset($attributes['multi_language']) && $attributes['multi_language'] && COM_isMultiLanguageEnabled()) {
                                $lang_id = COM_getLanguageIdForObject($id);
                            }
                            if (empty($lang_id)) {
                                // Assume default language of site
                                $lang_id = $LANG_ISO639_1;
                            }
                            $data['inLanguage'] = $lang_id;
                            break;

                        case $this::SCHEMA_TYPE_publisher:
                            $data['publisher'] = array(
                                "@type"     => "Organization",
                                "name" 	    => $_CONF['site_name'],
                                "url" 	    => $_CONF['site_url']
                            );

                            if (isset($_CONF['path_site_logo']) && !empty($_CONF['path_site_logo'])) {
                                $logo_path = rtrim($_CONF['path_html'], '/') . '/' . ltrim($_CONF['path_site_logo'], '/');
                                $sizeAttributes = COM_getImgSizeAttributes($logo_path, false);
                                if (is_array($sizeAttributes)) {
                                    $logo_url = rtrim($_CONF['site_url'], '/') . '/' . ltrim($_CONF['path_site_logo'], '/');
                                    $data['publisher']['logo'] = array(
                                        "@type"   => "ImageObject",
                                        "url"  => $logo_url,
                                        "width"  => $sizeAttributes['width'],
                                        "height"  => $sizeAttributes['height']
                                    );
                                }
                            }
                            break;

                        case $this::SCHEMA_TYPE_mainEntityOfPage:
                            if (isset($properties['url'])) {
                                $data['mainEntityOfPage'] = array(
                                    "@type"     => "WebPage",
                                    "@id" 	=> $properties['url'],
                                );
                            }
                            break;

                        case $this::SCHEMA_PROPERTY_TYPE:
                            // For Types within Types (ie Sub Types)
                            // Remember
                            //      $i is the name of the current property we are on that is a sub type
                            //      $item['value'] is the structured data type for the property
                            //      $properties[$i] is the list of properties for the sub type (which will be matched against the classes defined property types stored in $types)
                            //      $data[$i] is the subset of data that will need to be set for the structured data (passed by reference)
                            $data[$i] = array(); // create a space for the new type in the main array
                            $this->add_type($type, $id, $item['value'], $properties[$i], $attributes, $data[$i]);
                            break;

                        case $this::SCHEMA_PROPERTY_TYPE_REPEAT:
                            $data[$i] = array(); // create a space for the new type in the main array
                            // Cycle through each repeating type in the properties array
                            foreach($properties[$i] as $p => $type_repeat) {
                                $data[$i][$p] = array(); // create a space for the new type in the main array that allows for multiple entries of the same type
                                $this->add_type($type, $id, $item['value'], $type_repeat, $attributes, $data[$i][$p]);
                            }
                            break;

                        default:
                            // Shouldn't happen. Most likely means properties are not setup properly or a structured data type was not defined properly
                            break;
                    }
                }
            }
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
	 * Get a property of the structured data item
	 *
     * @param   string  $type       Plugin of the content used to create the structured data
     * @param   string  $id         Id of content
	 * @param   string $name        Name of property
	 */
	public function get_param_item($type, $id, $name)
    {
        $retval = '';
        $sd_name = $this->create_name($type, $id);
        if (isset($this->items[$sd_name][$name])) {
            $retval = $this->items[$sd_name][$name];
        }

        return $retval;
	}

    /**
	 * Set a author
	 *
     * @param   string  $type   Plugin of the content used to create the structured data
     * @param   string  $id     Id of content
	 * @param   string $name
	 */
	public function set_author_item($type, $id, $name, $url = '')
    {
        $sd_name = $this->create_name($type, $id);
        $this->items[$sd_name]['author'] = array(
            "@type"   => "Person",
            "name"  => $name,
        );
        if (!empty($url)) {
            $this->items[$sd_name]['author']['url'] = $url;
        }
	}

    /**
	 * Set a image to a type
	 *
     * @param   string  $type   Plugin of the content used to create the structured data
     * @param   string  $id     Id of content
	 */
	public function set_image_item($type, $id, $url, $width = '', $height = '')
    {
		global $_CONF;

		// Check if url local then add site_url if needed...
		if (substr($url, 0, 1) == "/") {
			$url = $_CONF['site_url'] . $url;
		}

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
