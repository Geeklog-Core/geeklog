@echo off

rem +---------------------------------------------------------------------------+
rem | Geeklog 2.1.0                                                             |
rem +---------------------------------------------------------------------------+
rem | uplng.bat                                                                 |
rem |                                                                           |
rem | Helper script to update the Geeklog language files,                       |
rem | using the lm.php script.                                                  |
rem +---------------------------------------------------------------------------+
rem | Copyright (C) 2004-2016 by the following authors:                         |
rem |                                                                           |
rem | Author:  Dirk Haun         - dirk AT haun-online DOT de                   |
rem |          Kenji ITO         - mystralkk AT gmail DOT com                   |
rem +---------------------------------------------------------------------------+
rem |                                                                           |
rem | This program is free software; you can redistribute it and/or             |
rem | modify it under the terms of the GNU General Public License               |
rem | as published by the Free Software Foundation; either version 2            |
rem | of the License, or (at your option) any later version.                    |
rem |                                                                           |
rem | This program is distributed in the hope that it will be useful,           |
rem | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
rem | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
rem | GNU General Public License for more details.                              |
rem |                                                                           |
rem | You should have received a copy of the GNU General Public License         |
rem | along with this program; if not, write to the Free Software Foundation,   |
rem | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
rem |                                                                           |
rem +---------------------------------------------------------------------------+

rem Installation and usage:
rem - copy this script into the /path/to/geeklog of a local Geeklog install
rem   Note that all *.php files in all of the language directories will be
rem   updated.

echo Syncing language files ...
set root=%~dp0\..\..\..\

rem path to the lm.php script and the include directory
set lm=%root%\system\build\lm\lm.php

call :doConvert %root%
call :doConvert %root% calendar
call :doConvert %root% links
call :doConvert %root% polls
call :doConvert %root% spamx
call :doConvert %root% staticpages
call :doConvert %root% xmlsitemap
call :doConvert %root% install

echo Done.
exit /b

:doConvert
rem @param  %1 = path
rem @param  %2 = module

if "%2"=="" (
	echo ===== Core =====
	set langpath=%root%\language
) else if  "%2"=="install" (
	echo ===== Install =====
	set langpath=%root%\public_html\admin\install\language
) else (
	echo ===== Plugin - %2 =====
	set langpath=%root%\plugins\%2\language
)

pushd %langpath%
	for /F "usebackq" %%f in (`dir /A-D /B *.php ^| findstr /V ^english`) do (
		echo %%f
		php.exe -f %lm% %langpath%\%%f %2 > %langpath%\%%f.tmp
		del %langpath%\%%f
		ren %langpath%\%%f.tmp %%f
	)
popd

exit /b
