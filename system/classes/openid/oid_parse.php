<?php

/*****
PHP OpenID - OpenID consumer and server library

Copyright (C) 2005 Open Source Consulting, SA. and Dan Libby

This library is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 2.1 of the License, or (at your option) any later version.

This library is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public
License along with this library; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA

Reciprocal linking.  The author humbly requests that if you should use 
PHP-OpenID on your website to provide an OpenID enabled service that you 
place a link to the author's website ( http://videntity.org ) somewhere 
that your users can discover it.  You are however under no obligation to 
do so.  

More info about PHP OpenID:
openid@videntity.org
http://videntity.org/openid/

More info about OpenID:
http://www.openid.net

*****/


class oidParse {

    // static, public
    // parses html data and returns <link> tag attributes.
    //
    // The return value is an array where each element 
    // is a sub-array containing all attribute/value
    // pairs from a single <link> tag.
    function parseLinkAttrs($data) {
    
        $tidy_ver = phpversion('tidy');
        if( (int)$tidy_ver == 2  ) {
            return oidParse::_parseLinkAttrsWithTidy2( $data );
        }
        // Todo: We could also have a method that uses Tidy1. volunteers?
        else {
            return oidParse::_parseLinkAttrsWithPreg( $data );
        }
        // Todo: We could also have a method that uses ereg. volunteers?
    }
    
    // static, private
    // parses all link attrs from an html page using perl regex ( preg/pcre )
    function _parseLinkAttrsWithPreg( $text ) {
    
        $tag_list = array();
    
        // find all tags
        preg_match_all('/<[^>]+>/s',$text,$tags);
        
        foreach ($tags[0] as $tag) {
               $gotten = preg_match('/^<\s*link\s*(.*)>/i',$tag,$alist);
               if ($gotten) {
                    // print "<b>$alist[1]</b><br" . XHTML . ">";
                    $cleaned = preg_replace('/\s+=\s+/','=',$alist[1]);
                    preg_match_all('/(?:^|\s)(\w+)="([^">]+)"/',$cleaned,$qatts);
                    preg_match_all('/(?:^|\s)(\w+)=([^"\s>]+)/',$cleaned,$patts);
                    $allatts = array_merge($patts[1],$qatts[1]);
                    $allvals = array_merge($patts[2],$qatts[2]);
                    $attrs = array();
                    for ($k=0; $k<count($allatts); $k++) {
                        $attrs[$allatts[$k]] = $allvals[$k];
                    }
                    $tag_list[] = $attrs;
               }
        }
        
        return $tag_list;
    }

    // static, private
    function _parseLinkAttrsWithTidy2Worker( $node, &$link_tags ) {
        
        $link_tags = $link_tags ? $link_tags : array();
        
        if(isset($node->id)) {
            if($node->id == TIDY_TAG_LINK ) {
            
                // $node->attribute is actually a mapped array with
                // key/val pairs for each of the nodes attributes.
                $link_tags[]  = $node->attribute;
                
            }
        }
        
        if( $node->hasChildren() ) {
    
            foreach($node->child as $next) {
                oidParse::_parseLinkAttrsWithTidy2Worker($next, $link_tags );
            }
    
        }
        
        return $link_tags;
    }
    
    // static, private
    function _parseLinkAttrsWithTidy2( $html ) {
        $tree = tidy_parse_string( $html );
        $tags = null;
        return oidParse::_parseLinkAttrsWithTidy2Worker( $tree->html(), $tags );
    }
    
    
};
        
        
?>
