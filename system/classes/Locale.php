<?php

namespace Geeklog;

use DateTime;
use DateTimeZone;
use Exception;

class Locale
{
    const DEFAULT_LOCALE = 'en';

    // Locales supported by Geeklog.  All keys must be in lower-case
    const SUPPORTED_LOCALES = [
        'af',       // Afrikaans
        'bs',       // Bosnian
        'bg',       // Bulgarian
        'ca',       // Catalan
        'cs',       // Czech
        'da',       // Danish
        'de',       // German
        'el',       // Hellenic
        'en',       // English
        'es',       // Spanish
        'et',       // Estonian
        'fa',       // Persian (rtl)
        'fi',       // Finnish
        'fr',       // French
        'he',       // Hebrew (rtl)
        'hr',       // Croatian
        'id',       // Indonesian
        'it',       // Italian
        'ja',       // Japanese
        'ko',       // Korean
        'nl',       // Dutch
        'no',       // Norwegian
        'pl',       // Polish
        'pt',       // Portuguese
        'ro',       // Romanian
        'ru',       // Russian
        'sk',       // Slovakian
        'sl',       // Slovenian
        'sr',       // Serbian
        'sv',       // Swedish
        'tr',       // Turkish
        'uk',       // Ukrainian
        'zh-hans',  // Chinese simplified
        'zh-hant',  // Chinese traditional
    ];

    /**
     * @var array
     */
    private $monthNames = [
        1  => 'January',
        2  => 'February',
        3  => 'March',
        4  => 'April',
        5  => 'May',
        6  => 'June',
        7  => 'July',
        8  => 'August',
        9  => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December',
    ];

    /**
     * @var array
     */
    private $shortMonthNames = [
        1  => 'Jan',
        2  => 'Feb',
        3  => 'Mar',
        4  => 'Apr',
        5  => 'May',
        6  => 'Jun',
        7  => 'Jul',
        8  => 'Aug',
        9  => 'Sep',
        10 => 'Oct',
        11 => 'Nov',
        12 => 'Dec',
    ];

    /**
     * @var array
     */
    private $dayNames = [
        1 => 'Sunday',
        2 => 'Monday',
        3 => 'Tuesday',
        4 => 'Wednesday',
        5 => 'Thursday',
        6 => 'Friday',
        7 => 'Saturday',
    ];

    /**
     * @var array
     */
    private $shortDayNames = [
        1 => 'Sun',
        2 => 'Mon',
        3 => 'Tue',
        4 => 'Wed',
        5 => 'Thu',
        6 => 'Fri',
        7 => 'Sat',
    ];

    /**
     * @var array
     */
    private $amPm = [
        'am_pm' => [
            'am' => 'am',
            'pm' => 'pm',
        ],
        'AM_PM' => [
            'am' => 'AM',
            'pm' => 'PM',
        ],
    ];

    /**
     * @var string[]
     */
    private static $dateFormats = [
        // dfid	=> format
        0  => '',
        1  => '%A %B %d, %Y @%I:%M%p',
        2  => '%A %b %d, %Y @%H:%M',
        4  => '%A %b %d @%H:%M',
        5  => '%H:%M %d %B %Y',
        6  => '%H:%M %A %d %B %Y',
        7  => '%I:%M%p - %A %B %d %Y',
        8  => '%a %B %d, %I:%M%p',
        9  => '%a %B %d, %H:%M',
        10 => '%m-%d-%y %H:%M',
        11 => '%d-%m-%y %H:%M',
        12 => '%m-%d-%y %I:%M%p',
        13 => '%I:%M%p  %B %e, %Y',
        14 => '%a %b %d, \'%y %I:%M%p',
        15 => "Day %j, %I ish",
        16 => '%y-%m-%d %I:%M',
        17 => '%d/%m/%y %H:%M',
        18 => '%a %d %b %I:%M%p',
        19 => '%Y-%m-%d %H:%M',
    ];

    /**
     * @var int
     */
    private $timestamp = 0;

    /**
     * @var int  time difference between local time and GMT.  If in EST (GMT-05:00), the $diff is -18,000
     */
    private $diff = 0;

    /**
     * @var string $timezone e.g. 'UTC', 'Europe/London', 'Asia/Tokyo'
     */
    private $timezone;

    /**
     * @var string  ISO639-1 code, e.g. en for English, fr for French
     * @todo Should support en_US, fr_CA?
     */
    private $locale = self::DEFAULT_LOCALE;

    /**
     * Locale class constructor
     *
     * @param  array  $monthNames       full month names like $LANG_MONTH
     * @param  array  $shortMonthNames  abbreviated month names like $LANG_MONTH_SHORT
     * @param  array  $dayNames         full day names like $LANG_WEEK
     * @param  array  $shortDayNames    abbreviated day names like $LANG_WEEK_SHORT
     * @param  array  $amPm             'am' and 'pm' like $LANG_AMPM
     * @param  array  $defaultDateFormat
     */
    public function __construct(array $monthNames, array $shortMonthNames, array $dayNames, array $shortDayNames, array $amPm, array $defaultDateFormat)
    {
        if (!empty($monthNames)) {
            $this->monthNames = $monthNames;
        }

        if (!empty($shortMonthNames)) {
            $this->shortMonthNames = $shortMonthNames;
        }

        if (!empty($dayNames)) {
            $this->dayNames = $dayNames;
        }

        if (!empty($shortDayNames)) {
            $this->shortDayNames = $shortDayNames;
        }

        if (!empty($amPm)) {
            $this->amPm = $amPm;
        }

        if (!empty($defaultDateFormat)) {
            self::$dateFormats[0] = $defaultDateFormat[0];
        }
    }

    /**
     * Format a local time/date according to locale settings
     *
     * @param  string    $format
     * @param  int|null  $timestamp  local time
     * @return string|false              Formatted date and time in local time, false on error
     */
    public function strftime($format, $timestamp = null)
    {
        $retval = '';

        $this->timestamp = ($timestamp === null) ? time() : $timestamp;

        while (($p = strpos($format, '%')) !== false) {
            if ($p > 0) {
                $retval .= substr($format, 0, $p);
                $format = substr($format, $p);
            }

            if (strpos($format, '%#d') === 0) {
                $retval .= date('j', $this->timestamp);
                $format = substr($format, 3);
                continue;
            }

            $spec = substr($format, 1, 1);
            $format = substr($format, 2);

            switch ($spec) {
                case 'a':  // 'Sun' - 'Sat'
                    $replace = $this->shortDayNames[(int) date('w', $this->timestamp) + 1];
                    break;

                case 'b':  // 'Jan' - 'Dec'
                case 'h':  // an alias of %b
                    $replace = $this->shortMonthNames[(int) date('n', $this->timestamp)];
                    break;

                case 'c':  // 'Tue Feb 5 00:45:10 2009
                    $day = $this->shortDayNames[(int) date('w', $this->timestamp) + 1];
                    $month = $this->shortMonthNames[(int) date('n', $this->timestamp)];

                    $replace = $day . ' ' . $month . date(' j H:i:s Y', $this->timestamp);
                    break;

                case 'd':  // day of the month: '01' - '31'
                    $replace = date('d', $this->timestamp);
                    break;

                case 'e':  // day of the month: '01' - '31'
                    $replace = date('j', $this->timestamp);
                    break;

                case 'g':  // 2-digit year (ISO-8601:1988): '09' for 2009
                    $replace = date('y', $this->timestamp); // FIXME
                    break;

                case 'j':  // 3-digit day of th year: '001' - '366'
                    $replace = substr('00' . ((int) date('z', $this->timestamp) + 1), -3);
                    break;

                case 'k':  // hour in 24-hour format: ' 0' - '23'
                    $replace = substr(' ' . date('G', $this->timestamp), -2);
                    break;

                case 'l':  // hour in 12-hour format: ' 1' - '12'
                    $replace = substr(' ' . date('g', $this->timestamp), -2);
                    break;

                case 'm':  // 2-digit month: '01' - '12'
                    $replace = date('m', $this->timestamp);
                    break;

                case 'n':  // new line character
                    $replace = "\n";
                    break;

                case 'p':  // lower case 'am', 'pm'
                    $replace = $this->amPm['am_pm'][date('a', $this->timestamp)];
                    break;

                case 'r':  // Same as "%I:%M:%S %p"
                    $replace = date('h:i:s a', $this->timestamp);  // FIXME
                    break;

                case 's':  // Unix Epoch Time timestamp same as time()
                    $replace = (string) $this->timestamp;
                    break;

                case 't':  // tab character
                    $replace = "\t";
                    break;

                case 'u':  // day of the week: 1 (Mon) - 7 (Sun)
                    $replace = date('N', $this->timestamp);
                    break;

                case 'w':  // day of the week: 0 (Sun) - 6 (Sat)
                    $replace = date('w', $this->timestamp);
                    break;

                case 'x':  // Preferred date representation: '02/05/09' for February 5, 2009
                    $replace = date('m/d/y', $this->timestamp); // FIXME
                    break;

                case 'y':  // two-digit year: '00' - '99'
                    $replace = date('y', $this->timestamp);
                    break;

                case 'z':  // time zone offset: -0500 for EST
                    $replace = date('O', $this->timestamp);
                    break;

                case 'A':  // 'Sunday' - 'Saturday'
                    $replace = $this->dayNames[(int) date('w', $this->timestamp) + 1];
                    break;

                case 'B':  // 'January' - 'December'
                    $replace = $this->monthNames[(int) date('n', $this->timestamp)];
                    break;

                case 'C':  // two-digit century: '19' for the 20th century
                    $replace = (string) floor((int) date('Y', $this->timestamp) / 100);
                    break;

                case 'D':  // Same as "%m/%d/%y": '02/05/09' for February 5, 2009
                    $replace = date('m/d/y', $this->timestamp);
                    break;

                case 'F':  // Same as "%Y-%m-%d"
                    $replace = date('Y-m-d', $this->timestamp);
                    break;

                case 'G':  // four-digit year (ISO-8601:1988)
                    $replace = date('Y', $this->timestamp); // FIXME
                    break;

                case 'H':  // two-digit hour in 24-hour format: '00' - '23'
                    $replace = date('H', $this->timestamp);
                    break;

                case 'I':  // two-digit hour in 12-hour format: '01' - '12'
                    $replace = date('h', $this->timestamp);
                    break;

                case 'M':  // two-digit minute: '00' - '59'
                    $replace = date('i', $this->timestamp);
                    break;

                case 'P':  // upper-case 'AM', 'PM'
                    $replace = $this->amPm['AM_PM'][date('a', $this->timestamp)];
                    break;

                case 'R':  // Same as "%H:%M"
                    $replace = date('H:i', $this->timestamp);
                    break;

                case 'S':  // two-digit second: '00' - '59'
                    $replace = date('s', $this->timestamp);
                    break;

                case 'T':  // Same as "%H:%M:%S"
                    $replace = date('H:i:s', $this->timestamp);
                    break;

                case 'U':  // Week number of the given year, starting with the firstSunday as the first week
                    $replace = date('W', $this->timestamp); // FIXME
                    break;

                case 'V':  // Week number of the given year, starting with the firstSunday as the first week (ISO-8601:1988)
                    $replace = date('W', $this->timestamp);
                    break;

                case 'W':  // A numeric representation of the week of the year, starting with the first Monday as the first week
                    $replace = date('W', $this->timestamp); // FIXME
                    break;

                case 'X':  // Preferred time representation based on locale, without the date
                    $replace = date('H:i:s', $this->timestamp); // FIXME
                    break;

                case 'Y':  // four-digit year
                    $replace = date('Y', $this->timestamp);
                    break;

                case 'Z':  // time zone abbreviation: 'EST'
                    $replace = date('T', $this->timestamp);
                    break;

                case '%':  // percent character
                    $replace = '%';
                    break;

                default:
                    // Unsupported specifier
                    return false;
            }

            $retval .= $replace;
        }

        $retval .= $format;

        return $retval;
    }

    /**
     * @param  string    $format
     * @param  int|null  $timestamp  local time
     * @return string|false          Formatted date and time in GMT
     */
    public function gmstrftime($format, $timestamp = null)
    {
        return $this->strftime($format, $timestamp - $this->diff);
    }

    /**
     * Get timezone
     *
     * @return string
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * Set timezone
     *
     * @param  string  $timezone
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;

        try {
            $tz = new DateTimeZone($timezone);
            $dateTime = new DateTime('now', new DateTimeZone($timezone));
        } catch (Exception $e) {
            $tz = new DateTimeZone('UTC');
            $dateTime = new DateTime('now', new DateTimeZone('UTC'));
        }

        $this->diff = $tz->getOffset($dateTime);
    }

    /**
     * Return the current locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set the locale to use
     *
     * @param  string  $locale
     * @return bool    true on success, false otherwise
     */
    public function setLocale($locale)
    {
        $locale = strtolower($locale);

        if (($pos = strpos($locale, '.')) !== false) {
            // Remove a string like '.UTF-8'
            $locale = substr($locale, 0, $pos);
        }

        if (in_array($locale, self::SUPPORTED_LOCALES)) {
            $this->locale = $locale;

            return true;
        }

        if (($pos = strpos($locale, '_')) !== false) {
            $locale = substr($locale, 0, $pos);
        }

        if (in_array($locale, self::SUPPORTED_LOCALES)) {
            $this->locale = $locale;

            return true;
        }

        if (($pos = strpos($locale, '-')) !== false) {
            $locale = substr($locale, 0, $pos);
        }

        if (in_array($locale, self::SUPPORTED_LOCALES)) {
            $this->locale = $locale;

            return true;
        } else {
            return false;
        }
    }

    /**
     * Return the timestamp to convert
     *
     * @return int
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set the timestamp to convert (for tests)
     *
     * @param  int  $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = (int) $timestamp;
    }

    /**
     * Convert the date time format ID to the string representing the format
     *
     * @param  int  $dfId
     * @return string
     */
    public static function dateFormatIdToString($dfId)
    {
        $dfId = (int) $dfId;

        return array_key_exists($dfId, self::$dateFormats) ? self::$dateFormats[$dfId] : '';
    }

    /**
     * Return an array of options elements to use in the date format selector
     *
     * @param  int   $selectedDfId  date format ID currently selected
     * @param  bool  $asArray       true if return the result as an array, false as a string
     * @return array|string
     */
    public function getDateFormatOptions($selectedDfId, $asArray = false)
    {
        $selectedDfId = (int) $selectedDfId;
        $now = time();
        $options = [];

        foreach (self::$dateFormats as $dfId => $format) {
            $electedStr = ($selectedDfId === $dfId) ? ' selected="selected"' : '';
            $options[] = '<option value="' . $dfId . '"' . $electedStr . '>'
                . $this->strftime($format, $now)
                . '</option>';
        }


        return $asArray ? $options : implode("\n", $options) . "\n";
    }
}
