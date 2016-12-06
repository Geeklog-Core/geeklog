<?php

/**
 * Create the Spam-X rss feed
 * 
 * @param items $ array of blacklisted sites
 *
 * $Id: rss.inc.php,v 1.3 2005/04/10 10:02:46 dhaun Exp $
 */

function Spamx_rss($items)
{
    global $_CONF; 
    // Basic Data
    $about = $_CONF['site_url'] . '/spamx/index.php';
    $title = 'Spam-X Blacklist';
    $description = 'Personal Spamx Blacklist from site ' . $_CONF['site_name']; 
    // Dublic Core Data
    $dc = array('dc:publisher' => $_CONF['site_name'],
        'dc:creator' => $_CONF['site_name'],
        'dc:date' => time());
    $rssfile = new RSSWriter($about, $title, $description, $dc); 
    // Add items
    foreach($items as $item) {
        $about = $_CONF['site_url'] . '/spamx/index.php';
        $title = $item;
        $description = $item;
        $dc = array('dc:subject' => 'Personal Blacklist',
            'dc:author' => $_CONF['site_name']);
        $rssfile->addItem($about, $title, $dc);
    } 
    // Now write the file
    $buff = $rssfile->serialize();
    $rdfpath = dirname($_CONF['rdf_file']);
    $rdffile = $rdfpath . '/spamx.rdf';
    $fp = fopen($rdffile, "w");
    fputs($fp, $buff);
    fclose($fp);
} 

// A convenience class to make it easy to write RSS classes
// Edd Dumbill <mailto:edd+rsswriter@usefulinc.com>

// Revision 1.4  2004/06/11 11:00  towm
// Changed output to string

// Revision 1.3  2001/05/20 17:58:02  edmundd
// Final distribution tweaks.

// Revision 1.2  2001/05/20 17:41:30  edmundd
// Ready for distribution.

// Revision 1.1  2001/05/20 17:01:43  edmundd
// First functional draft of code working.

// Revision 1.1  2001/05/17 18:17:46  edmundd
// Start of a convenience library to help RSS1.0 creation

class RSSWriter {
    function RSSWriter($uri, $title, $description, $meta = array())
    {
        $this->chaninfo = array();
        $this->website = $uri;
        $this->chaninfo["link"] = $uri;
        $this->chaninfo["description"] = $description;
        $this->chaninfo["title"] = $title;
        $this->items = array();
        $this->modules = array("dc" => "http://purl.org/dc/elements/1.1/");
        $this->channelURI = str_replace("&", "&amp;", "http://" . $GLOBALS["SERVER_NAME"] . $GLOBALS["REQUEST_URI"]);
        foreach ($meta as $key => $value) {
            $this->chaninfo[$key] = $value;
        } 
    } 

    function useModule($prefix, $uri)
    {
        $this->modules[$prefix] = $uri;
    } 

    function setImage($imgURI, $imgAlt, $imgWidth = 88, $imgHeight = 31)
    {
        $this->image = array("uri" => $imgURI, "title" => $imgAlt, "width" => $imgWidth,
            "height" => $imgHeight);
    } 

    function addItem($uri, $title, $meta = array())
    {
        $item = array("uri" => $uri, "link" => $uri,
            "title" => $this->deTag($title));
        foreach ($meta as $key => $value) {
            if ($key == "description" || $key == "dc:description") {
                $value = $this->deTag($value);
            } 
            $item[$key] = $value;
        } 
        $this->items[] = $item;
    } 

    function serialize()
    {
        $buff = $this->preamble();
        $buff .= $this->channelinfo();
        $buff .= $this->image();
        $buff .= $this->items();
        $buff .= $this->postamble();
        return $buff;
    } 

    function deTag($in)
    {
        while (ereg('<[^>]+>', $in)) {
            $in = ereg_replace('<[^>]+>', '', $in);
        } 
        return $in;
    } 

    function preamble()
    { 
        // header("Content-type: text/xml");
        $display = '<?xml version="1.0" encoding="iso-8859-1"?>
<rdf:RDF 
         xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
         xmlns="http://purl.org/rss/1.0/"
         xmlns:mn="http://usefulinc.com/rss/manifest/"
';
        foreach ($this->modules as $prefix => $uri) {
            $display .= "         xmlns:${prefix}=\"${uri}\"\n";
        } 
        $display .= ">\n\n";
        return $display;
    } 

    function channelinfo()
    {
        $display = '  <channel rdf:about="' . $this->channelURI . '">';
        $i = $this->chaninfo;
        foreach (array("title", "link", "dc:source", "description", "dc:language", "dc:publisher",
                "dc:creator", "dc:rights") as $f) {
            if (isset($i[$f])) {
                $display .= "    <${f}>" . htmlspecialchars($i[$f]) . "</${f}>\n";
            } 
        } 
        if (isset($this->image)) {
            $display .= "    <image rdf:resource=\"" . htmlspecialchars($this->image["uri"]) . "\" />\n";
        } 
        $display .= "    <items>\n";
        $display .= "      <rdf:Seq>\n";
        foreach ($this->items as $i) {
            $display .= "        <rdf:li rdf:resource=\"" . htmlspecialchars($i["uri"]) . "\" />\n";
        } 
        $display .= "      </rdf:Seq>\n";
        $display .= "    </items>\n";
        $display .= "  </channel>\n\n";
        return $display;
    } 

    function image()
    {
        $display = '';
        if (isset($this->image)) {
            $display .= "  <image rdf:about=\"" . htmlspecialchars($this->image["uri"]) . "\">\n";
            $display .= "     <title>" . htmlspecialchars($this->image["title"]) . "</title>\n";
            $display .= "     <url>" . htmlspecialchars($this->image["uri"]) . "</url>\n";
            $display .= "     <link>" . htmlspecialchars($this->website) . "</link>\n";
            if ($this->chaninfo["description"])
                $display .= "     <dc:description>" . htmlspecialchars($this->chaninfo["description"]) . "</dc:description>\n";
            $display .= "  </image>\n\n";
        } 
        return $display;
    } 

    function postamble()
    {
        $display = '  <rdf:Description rdf:ID="manifest">
    <mn:channels>
      <rdf:Seq>
        <rdf:li rdf:resource="' . $this->channelURI . '" />
      </rdf:Seq>
    </mn:channels>
  </rdf:Description>

</rdf:RDF>
';
        return $display;
    } 

    function items()
    {
        $display = '';
        foreach ($this->items as $item) {
            $display .= "  <item rdf:about=\"" . htmlspecialchars($item["uri"]) . "\">\n";
            foreach ($item as $key => $value) {
                if ($key != "uri") {
                    if (is_array($value)) {
                        foreach ($value as $v1) {
                            $display .= "    <${key}>" . htmlspecialchars($v1) . "</${key}>\n";
                        } 
                    } else {
                        $display .= "    <${key}>" . htmlspecialchars($value) . "</${key}>\n";
                    } 
                } 
            } 
            $display .= "  </item>\n\n";
        } 
        return $display;
    } 
} 

?>
