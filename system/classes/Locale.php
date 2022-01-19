<?php

namespace Geeklog;

use DateTime;
use DateTimeZone;
use Exception;

class Locale
{
    const DEFAULT_LOCALE = 'en';

    // All keys must be in lower-case
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
    protected $timezone;

    /**
     * @var string  ISO639-1 code, e.g. en for English, fr for French
     * @todo Should support en_US, fr_CA?
     */
    private $locale = self::DEFAULT_LOCALE;

    /**
     * Locale constructor
     *
     * @param  array  $monthNames
     * @param  array  $shortMonthNames
     * @param  array  $dayNames
     * @param  array  $shortDayNames
     * @param  array  $amPm
     */
    public function __construct(array $monthNames, array $shortMonthNames, array $dayNames, array $shortDayNames, array $amPm)
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
    }

    /**
     * Callback function for self::strftime
     *
     * @param  array  $matches
     * @return string
     */
    public function convertDateTime(array $matches)
    {
        $spec = $matches[0];

        switch ($spec) {
            case '%a':  // 'Sun' - 'Sat'
                return $this->shortDayNames[(int) date('w', $this->timestamp) + 1];

            case '%b':  // 'Jan' - 'Dec'
            case '%h':  // an alias of %b
                return $this->shortMonthNames[(int) date('n', $this->timestamp)];

            case '%c':  // 'Tue Feb 5 00:45:10 2009
                $day = $this->shortDayNames[(int) date('w', $this->timestamp) + 1];
                $month = $this->shortMonthNames[(int) date('n', $this->timestamp)];

                return $day . ' ' . $month . date(' j H:i:s Y', $this->timestamp);

            case '%d':  // day of the month: '01' - '31'
                return date('d', $this->timestamp);

            case '%e':  // day of the month: '01' - '31'
            case '%#d':
                return date('j', $this->timestamp);

            case '%g':  // 2-digit year (ISO-8601:1988): '09' for 2009
                return date('y', $this->timestamp); // FIXME

            case '%j':  // 3-digit day of th year: '001' - '366'
                return substr('00' . (string) ((int) date('z', $this->timestamp) + 1), -3);

            case '%k':  // hour in 24-hour format: ' 0' - '23'
                return substr(' ' . date('G', $this->timestamp), -2);

            case '%l':  // hour in 12-hour format: ' 1' - '12'
                return substr(' ' . date('g', $this->timestamp), -2);

            case '%m':  // 2-digit month: '01' - '12'
                return date('m', $this->timestamp);

            case '%n':  // new line character
                return "\n";

            case '%p':  // lower case 'am', 'pm'
                return $this->amPm['am_pm'][date('a', $this->timestamp)];

            case '%r':  // Same as "%I:%M:%S %p"
                return date('h:i:s a', $this->timestamp);  // FIXME

            case '%s':  // Unix Epoch Time timestamp same as time()
                return (string) $this->timestamp;

            case '%t':  // tab character
                return "\t";

            case '%u':  // day of the week: 1 (Mon) - 7 (Sun)
                return date('N', $this->timestamp);

            case '%w':  // day of the week: 0 (Sun) - 6 (Sat)
                return date('w', $this->timestamp);

            case '%x':  // Preferred date representation: '02/05/09' for February 5, 2009
                return date('m/d/y', $this->timestamp); // FIXME

            case '%y':  // two-digit year: '00' - '99'
                return date('y', $this->timestamp);

            case '%z':  // time zone offset: -0500 for EST
                return date('O', $this->timestamp);

            case '%A':  // 'Sunday' - 'Saturday'
                return $this->dayNames[(int) date('w', $this->timestamp) + 1];

            case '%B':  // 'January' - 'December'
                return $this->monthNames[(int) date('n', $this->timestamp)];

            case '%C':  // two-digit century: '19' for the 20th century
                return (string) floor((int) date('Y', $this->timestamp) / 100);

            case '%D':  // Same as "%m/%d/%y": '02/05/09' for February 5, 2009
                return date('m/d/y', $this->timestamp);

            case '%F':  // Same as "%Y-%m-%d"
                return date('Y-m-d', $this->timestamp);

            case '%G':  // four-digit year (ISO-8601:1988)
                return date('Y', $this->timestamp); // FIXME

            case '%H':  // two-digit hour in 24-hour format: '00' - '23'
                return date('H', $this->timestamp);

            case '%I':  // two-digit hour in 12-hour format: '01' - '12'
                return date('h', $this->timestamp);

            case '%M':  // two-digit minute: '00' - '59'
                return date('i', $this->timestamp);

            case '%P':  // upper-case 'AM', 'PM'
                return $this->amPm['AM_PM'][date('a', $this->timestamp)];

            case '%R':  // Same as "%H:%M"
                return date('H:i', $this->timestamp);

            case '%S':  // two-digit second: '00' - '59'
                return date('s', $this->timestamp);

            case '%T':  // Same as "%H:%M:%S"
                return date('H:i:s', $this->timestamp);

            case '%U':  // Week number of the given year, starting with the firstSunday as the first week
                return date('W', $this->timestamp); // FIXME

            case '%V':  // Week number of the given year, starting with the firstSunday as the first week (ISO-8601:1988)
                return date('W', $this->timestamp);

            case '%W':  // A numeric representation of the week of the year, starting with the first Monday as the first week
                return date('W', $this->timestamp); // FIXME

            case '%X':  // Preferred time representation based on locale, without the date
                return date('H:i:s', $this->timestamp); // FIXME

            case '%Y':  // four-digit year
                return date('Y', $this->timestamp);

            case '%Z':  // time zone abbreviation: 'EST'
                return date('T', $this->timestamp);

            case '%%':  // percent character
                return '%';

            default:
                // Ignore unsupported specifier
                return '';
        }
    }

    /**
     * @param  string    $format
     * @param  int|null  $timestamp  local time
     * @return string                Formatted date and time in local time
     */
    public function strftime($format, $timestamp = null)
    {
        $this->timestamp = ($timestamp === null) ? time() : $timestamp;

        $retval = $format;
        $retval = preg_replace_callback(
            '/%(#d|[abcdeghjklmnprstxuwyzABCDFGHIMPRSTUVWXYZ%])/',
            [$this, 'convertDateTime'],
            $retval
        );

        return ($retval === null) ? false : $retval;
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
}
