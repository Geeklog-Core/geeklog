#!/bin/bash
# +---------------------------------------------------------------------------+
# | Geeklog 2.1                                                               |
# +---------------------------------------------------------------------------+
# | uplng.sh                                                                  |
# |                                                                           |
# | Helper script to update the Geeklog language files,                       |
# | using the lm.php script.                                                  |
# +---------------------------------------------------------------------------+
# | Copyright (C) 2004-2009 by the following authors:                         |
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
#   deleted and new language files will be created there
# - adjust paths below
# - cd /path/to/geeklog, run the script

# just a basedir to save some typing ...
basedir=`pwd`/../../../

# the /path/to/geeklog of your local copy of the Mercurial repository
cvspath=$basedir

# target directory - where this script is located aka /path/to/geeklog
destpath=$basedir

# path to the lm.php script and the include directory
lm=$basedir/system/build/lm/lm.php

# you shouldn't need to change anything below ...

function doConvert() { # parameters: "to" "from" "module"

  if [ -z "$3" ]; then
    echo "=== Core ==="

    modpath=$1/language
    langpath=$2/language
  elif [ "$3" = "install" ]; then
    echo "=== $3 ==="

    modpath=$1/public_html/admin/$3/language
    langpath=$2/public_html/admin/$3/language
  else
    echo "=== $3 ==="

    modpath=$1/plugins/$3/language
    langpath=$2/plugins/$3/language
  fi

  cd $modpath
  rm -f *.php

  cd $langpath
  files=`ls -1 *.php | grep -v english.php | grep -v english_utf-8.php`

  cp english.php $modpath
  if [ -e english_utf-8.php ]; then
    cp english_utf-8.php $modpath
  fi

  cd $destpath
  for l in $files; do
    echo "$l"
    php $lm $langpath/$l "$3" > $modpath/$l
  done

}

doConvert $destpath $cvspath
doConvert $destpath $cvspath "calendar"
doConvert $destpath $cvspath "links"
doConvert $destpath $cvspath "polls"
doConvert $destpath $cvspath "spamx"
doConvert $destpath $cvspath "staticpages"
doConvert $destpath $cvspath "xmlsitemap"
doConvert $destpath $cvspath "install"
