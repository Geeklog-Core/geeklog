<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.1                                                               |
// +---------------------------------------------------------------------------+
// | timezoneconfig.class.php                                                  |
// |                                                                           |
// | Helper class for time zone handling                                       |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009 by the following authors:                              |
// |                                                                           |
// | Authors: Dirk Haun             - dirk AT haun-online DOT de               |
// | based on earlier work by Oliver Spiesshofer, Yew Loong, and others        |
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
 * Geeklog Time Zone Config class
 * A collection of static (for now) methods dealing with time zone handling.
 * For the original "Timezone Hack" discussion, see
 *
 * @link   https://www.geeklog.net/forum/viewtopic.php?showtopic=21232
 * @author Dirk Haun, dirk AT haun-online DOT de
 */
class TimeZoneConfig
{
    /**
     * Set the system's timezone
     *
     * @param    string $tz timezone to set; use $_CONF['timezone'] if empty
     * @return   void
     */
    public static function setSystemTimeZone($tz = '')
    {
        global $_CONF;

        static $system_timezone = '';

        if (empty($tz) && !empty($_CONF['timezone'])) {
            $tz = $_CONF['timezone'];
        }

        if (!empty($tz)) {
            if ($tz != $system_timezone) {
                if (function_exists('date_default_timezone_set')) {
                    if (!@date_default_timezone_set($tz)) {
                        date_default_timezone_set('UTC');
                        COM_errorLog("Timezone '$tz' not valid - using 'UTC' instead", 1);
                        $system_timezone = 'UTC';
                    } else {
                        $system_timezone = $tz;
                    }
                } elseif (!ini_get('safe_mode') && function_exists('putenv')) {
                    // aka "Timezone Hack"
                    putenv('TZ=' . $tz);
                    $system_timezone = $tz;
                }
            }
        } elseif (function_exists('date_default_timezone_get')) {
            // this is not ideal but will stop PHP 5.3.0ff from complaining ...
            $system_timezone = @date_default_timezone_get();
            date_default_timezone_set($system_timezone);
        }
    }

    /**
     * Set the user's preferred timezone
     * Note that it does nothing if $_CONF['timezone'] is empty, i.e. if no
     * system timezone is defined, we don't set a user timezone either.
     *
     * @return void
     */
    public static function setUserTimeZone()
    {
        global $_CONF;

        if (!empty($_CONF['timezone'])) {
            $tz = self::getUserTimeZone();
            if (!empty($tz)) {
                self::setSystemTimeZone($tz);
            }
        }
    }

    /**
     * Get the user's preferred timezone
     *
     * @return   string  name of the timezone
     */
    public static function getUserTimeZone()
    {
        global $_CONF, $_USER;

        // handle like the theme cookie, i.e. use if user is not logged in
        if (isset($_COOKIE[$_CONF['cookie_tzid']]) && empty($_USER['tzid'])) {
            $_USER['tzid'] = $_COOKIE[$_CONF['cookie_tzid']];
        }

        if (!empty($_USER['tzid'])) {
            $timezone = $_USER['tzid'];
        } elseif (!empty($_CONF['timezone'])) {
            $timezone = $_CONF['timezone'];
        } elseif (function_exists('date_default_timezone_get')) {
            $timezone = @date_default_timezone_get();
        } else {
            $tz_obj = Date_TimeZone::getDefault();
            $timezone = $tz_obj->id;
        }

        return $timezone;
    }

    /**
     * Provide a dropdown menu of the available timezones
     *
     * @param    string $selected   (optional) currently selected timezone
     * @param    array  $attributes (optional) extra attributes for select tag
     * @return   string              HTML for the dropdown
     */
    public static function getTimeZoneDropDown($selected = '', $attributes = array())
    {
        $timezones = self::listAvailableTimeZones();

        $selection = '<select';
        foreach ($attributes as $name => $value) {
            $selection .= sprintf(' %s="%s"', $name, $value);
        }
        $selection .= '>' . LB;

        foreach ($timezones as $tzId => $tzDisplay) {
            $selection .= '<option value="' . $tzId . '"';
            if (!empty($selected) && ($selected == $tzId)) {
                $selection .= ' selected="selected"';
            }
            $selection .= ">{$tzDisplay}</option>" . LB;
        }
        $selection .= '</select>';

        return $selection;
    }

    /**
     * Provide a list of available timezones
     *
     * @return   array   array of (timezone-short-name, timezone-long-name) pairs
     */
    public static function listAvailableTimeZones()
    {
        $timezones = array();

        // use only timezones that contain one of these
        $useOnly = array(
            'Africa', 'America', 'Antarctica', 'Arctic', 'Asia',
            'Atlantic', 'Australia', 'Europe', 'Indian', 'Pacific', 'UTC',
        );

        // check if we can use the DateTimeZone class
        $useDateTimeZone = false;
        if (class_exists('DateTimeZone') && class_exists('ReflectionClass')) {
            $rc = new ReflectionClass('DateTimeZone');
            if ($rc->hasMethod('listAbbreviations')) {
                $useDateTimeZone = true;
            }
        }

        if ($useDateTimeZone) {
            $T = DateTimeZone::listAbbreviations();

            foreach ($T as $tzId => $entries) {
                $shortName = strtoupper($tzId);
                foreach ($entries as $data) {
                    $tzCheck = explode('/', $data['timezone_id']);
                    if (!in_array($tzCheck[0], $useOnly)) {
                        continue;
                    }

                    $hours = $data['offset'] / 3600;
                    $hours = ((int) ($hours * 100) / 100);
                    if ($hours > 0) {
                        $hours = "+$hours";
                    }

                    $tzCode = str_replace('_', ' ', $data['timezone_id']);
                    $tzCode = htmlspecialchars($tzCode);
                    $formattedTimezone = "$hours, $shortName ($tzCode)";
                    $timezones[$data['timezone_id']] = $formattedTimezone;
                }
            }

        } else { // DateTimeZone not available - use PEAR Date class
            // Load Date_TimeZone class
            Date_TimeZone::getDefault();
            $T = $GLOBALS['_DATE_TIMEZONE_DATA'];

            foreach ($T as $tzId => $tDetails) {
                $tzCheck = explode('/', $tzId);
                if (!in_array($tzCheck[0], $useOnly)) {
                    continue;
                }
                if (!empty($tzCheck[1]) &&
                    (strpos($tzCheck[1], 'Riyadh') === 0)
                ) {
                    // these time zones are based on solar time and not widely
                    // supported - skip
                    continue;
                }

                $tzCode = str_replace('_', ' ', $tzId);
                $tzCode = htmlspecialchars($tzCode);
                $hours = $tDetails['offset'] / (3600 * 1000);
                $hours = ((int) ($hours * 100) / 100);
                if ($hours > 0) {
                    $hours = "+$hours";
                }

                $formattedTimezone = "$hours, {$tDetails['shortname']} ($tzCode)";
                $timezones[$tzId] = $formattedTimezone;
            }

        }

        uasort($timezones, array('TimeZoneConfig', '_sort_by_timezone'));

        return $timezones;
    }

    /**
     * Helper method: Sort timezone entries
     *
     * @param    string $tz1 first timezone
     * @param    string $tz2 second timezone
     * @return   int             0: equal, <0: first<second, >0: first>second
     */
    private static function _sort_by_timezone($tz1, $tz2)
    {
        $p1 = explode(',', $tz1);
        $p2 = explode(',', $tz2);

        // compare offsets
        $o1 = $p1[0];
        $o2 = $p2[0];
        if ($o1 != $o2) {
            return ($o1 < $o2 ? -1 : 1);
        }

        // drop offset, pop timezone name, then add it to the end again
        array_shift($p1);
        $tz1 = trim(implode(',', $p1));
        $p1 = explode(' ', $tz1);
        $x1 = array_shift($p1);
        $p1[] = $x1;
        $tz1 = implode(' ', $p1);

        array_shift($p2);
        $tz2 = trim(implode(',', $p2));
        $p2 = explode(' ', $tz2);
        $x2 = array_shift($p2);
        $p2[] = $x2;
        $tz2 = implode(' ', $p2);

        return strcmp($tz1, $tz2);
    }
}
