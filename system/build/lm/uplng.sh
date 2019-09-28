#!/bin/bash
# +---------------------------------------------------------------------------+
# | Geeklog 2.2.0                                                             |
# +---------------------------------------------------------------------------+
# | uplng.sh                                                                  |
# |                                                                           |
# | Helper script to update the Geeklog language files,                       |
# | using the lm.php script.                                                  |
# +---------------------------------------------------------------------------+
# | Copyright (C) 2004-2019 by the following authors:                         |
# |                                                                           |
# | Author:  Dirk Haun         - dirk AT haun-online DOT de                   |
# +---------------------------------------------------------------------------+
# |                                                                           |
# | This program is free software; you can redistribute it and/or             |
# | modify it under the terms of the GNU General Public License               |
# | as published by the Free Software Foundation; either version 2            |
# | of the License, or (at your option) any later version.                    |
# |                                                                           |
# | This program is distributed in the hope that it will be useful,           |
# | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
# | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
# | GNU General Public License for more details.                              |
# |                                                                           |
# | You should have received a copy of the GNU General Public License         |
# | along with this program; if not, write to the Free Software Foundation,   |
# | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
# |                                                                           |
# +---------------------------------------------------------------------------+

# Installation and usage:
# - copy this script into the /path/to/geeklog of a local Geeklog install
#   Note that all *.php files in all of the language directories will be
#   updated.

echo Syncing language files ...

root=`pwd`
gl_version=$1
# path to the lm.php script and the include directory
lm=$root/system/build/lm/lm.php

# you shouldn't need to change anything below ...

# @param  $1 = version
# @param  $2 = path
# @param  $3 = module
function doConvert() {

  if [ -z "$3" ]; then
    echo "=== Core ==="
    #echo $1
    #echo $2
    langpath=$2/language
  elif [ "$3" = "install" ]; then
    echo "=== Install ==="
    langpath=$2/public_html/admin/$3/language
  else
    echo "=== Plugin - $3 ==="
    langpath=$2/plugins/$3/language
  fi

  #cd $modpath
  #rm -f *.php

  cd $langpath
  #files=`ls -1 *.php | grep -v english.php | grep -v english_utf-8.php`
  files=`ls -1 *.php | grep -v english.php | grep -v _list.php`

  #cp english.php $modpath
  #if [ -e english_utf-8.php ]; then
  #  cp english_utf-8.php $modpath
  #fi

  for l in $files; do
    echo $l
    php $lm $1 $langpath/$l "$3" > $langpath/$l.tmp
	rm -f $langpath/$l
	mv -f $langpath/$l.tmp $langpath/$l
  done

}

doConvert $1 $root
doConvert $1 $root "calendar"
doConvert $1 $root "links"
doConvert $1 $root "polls"
doConvert $1 $root "spamx"
doConvert $1 $root "staticpages"
doConvert $1 $root "xmlsitemap"
doConvert $1 $root "install"

echo Done.
