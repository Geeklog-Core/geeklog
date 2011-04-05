<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.8                                                               |
// +---------------------------------------------------------------------------+
// | validator.class.php                                                       |
// |                                                                           |
// | Used for validation of data                                               |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2010-2011 by the following authors:                         |
// |                                                                           |
// | Authors: Akeda Bagus       - admin AT gedex DOT web DOT id                |
// |                                                                           |
// | Copyright 2005-2010,                                                      |
// | Cake Software Foundation, Inc. (http://cakefoundation.org)                |
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
 * This class allows you to make a validation given input values along with its rules.
 * The process is very similiar with CakePHP Model Validation. Much of code in this class
 * were borrowed from CakePHP Validation Class.
 *
 * @see http://book.cakephp.org/view/1143/Data-Validation
 * @author Akeda Bagus
 *
 */
class validator {

/**
 * Set the the value of methods $check param.
 *
 * @var string
 * @access public
 */
	var $check = null;

/**
 * Set to a valid regular expression in the class methods.
 * Can be set from $regex param also
 *
 * @var string
 * @access public
 */
	var $regex = null;

/**
 * Some complex patterns needed in multiple places
 *
 * @var array
 * @access private
 */
	var $__pattern = array(
		'hostname' => '(?:[a-z0-9][-a-z0-9]*\.)*(?:[a-z0-9][-a-z0-9]{0,62})\.(?:(?:[a-z]{2}\.)?[a-z]{2,4}|museum|travel)'
	);

/**
 * Some class methods use the $type param to determine which validation to perfom in the method
 *
 * @var string
 * @access public
 */
	var $type = null;

/**
 * Holds an array of errors messages set in this class.
 * These are used for debugging purposes
 *
 * @var array
 * @access public
 */
	var $errors = array();

/**
 * Gets a reference to the Validation object instance
 *
 * @return object Validation instance
 * @access public
 * @static
 */    
    function &getInstance() {
		static $instance = array();

		if (!$instance) {
			$instance[0] = new validator();
		}
		return $instance[0];
	}

/**
 * Calls a method on this object with the given parameters. Provides an OO wrapper
 * for call_user_func_array, and improves performance by using straight method calls
 * in most cases.
 *
 * @param string $method  Name of the method to call
 * @param array $params  Parameter list to use when calling $method
 * @return mixed  Returns the result of the method call
 * @access public
 */
	function dispatchMethod($method, $params = array()) {
		switch (count($params)) {
			case 0:
				return $this->{$method}();
			case 1:
				return $this->{$method}($params[0]);
			case 2:
				return $this->{$method}($params[0], $params[1]);
			case 3:
				return $this->{$method}($params[0], $params[1], $params[2]);
			case 4:
				return $this->{$method}($params[0], $params[1], $params[2], $params[3]);
			case 5:
				return $this->{$method}($params[0], $params[1], $params[2], $params[3], $params[4]);
			default:
				return call_user_func_array(array(&$this, $method), $params);
			break;
		}
	}
    
/**
 * Checks that a string contains something other than whitespace
 *
 * Returns true if string contains something other than whitespace
 *
 * $check can be passed as an array:
 * array('check' => 'valueToCheck');
 *
 * @param mixed $check Value to check
 * @return boolean Success
 * @access public
 */
	function notEmpty($check) {
		$_this =& validator::getInstance();
		$_this->__reset();
		$_this->check = $check;

		if (is_array($check)) {
			$_this->_extract($check);
		}

		if (empty($_this->check) && $_this->check != '0') {
			return false;
		}
		$_this->regex = '/[^\s]+/m';
		return $_this->_check();
	}

/**
 * Checks that a string contains only integer or letters
 *
 * Returns true if string contains only integer or letters
 *
 * $check can be passed as an array:
 * array('check' => 'valueToCheck');
 *
 * @param mixed $check Value to check
 * @return boolean Success
 * @access public
 */
	function alphaNumeric($check) {
		$_this =& validator::getInstance();
		$_this->__reset();
		$_this->check = $check;

		if (is_array($check)) {
			$_this->_extract($check);
		}

		if (empty($_this->check) && $_this->check != '0') {
			return false;
		}
		$_this->regex = '/^[\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd}]+$/mu';
		return $_this->_check();
	}

/**
 * Checks that a string length is within s specified range.
 * Spaces are included in the character count.
 * Returns true is string matches value min, max, or between min and max,
 *
 * @param string $check Value to check for length
 * @param integer $min Minimum value in range (inclusive)
 * @param integer $max Maximum value in range (inclusive)
 * @return boolean Success
 * @access public
 */
	function between($check, $min, $max) {
		$length = MBYTE_strlen($check);
		return ($length >= $min && $length <= $max);
	}
    
/**
 * Returns true if field is left blank -OR- only whitespace characters are present in it's value
 * Whitespace characters include Space, Tab, Carriage Return, Newline
 *
 * $check can be passed as an array:
 * array('check' => 'valueToCheck');
 *
 * @param mixed $check Value to check
 * @return boolean Success
 * @access public
 */
	function blank($check) {
		$_this =& validator::getInstance();
		$_this->__reset();
		$_this->check = $check;

		if (is_array($check)) {
			$_this->_extract($check);
		}

		$_this->regex = '/[^\\s]/';
		return !$_this->_check();
	}

/**
 * Used to compare 2 numeric values.
 *
 * @param mixed $check1 if string is passed for a string must also be passed for $check2
 *    used as an array it must be passed as array('check1' => value, 'operator' => 'value', 'check2' -> value)
 * @param string $operator Can be either a word or operand
 *    is greater >, is less <, greater or equal >=
 *    less or equal <=, is less <, equal to ==, not equal !=
 * @param integer $check2 only needed if $check1 is a string
 * @return boolean Success
 * @access public
 */
	function comparison($check1, $operator = null, $check2 = null) {
		if (is_array($check1)) {
			extract($check1, EXTR_OVERWRITE);
		}
		$operator = str_replace(array(' ', "\t", "\n", "\r", "\0", "\x0B"), '', strtolower($operator));

		switch ($operator) {
			case 'isgreater':
			case '>':
				if ($check1 > $check2) {
					return true;
				}
				break;
			case 'isless':
			case '<':
				if ($check1 < $check2) {
					return true;
				}
				break;
			case 'greaterorequal':
			case '>=':
				if ($check1 >= $check2) {
					return true;
				}
				break;
			case 'lessorequal':
			case '<=':
				if ($check1 <= $check2) {
					return true;
				}
				break;
			case 'equalto':
			case '==':
				if ($check1 == $check2) {
					return true;
				}
				break;
			case 'notequal':
			case '!=':
				if ($check1 != $check2) {
					return true;
				}
				break;
			default:
				$_this =& validator::getInstance();
				$_this->errors[] = __('You must define the $operator parameter for validator::comparison()', true);
				break;
		}
		return false;
	}

/**
 * Used when a custom regular expression is needed.
 *
 * @param mixed $check When used as a string, $regex must also be a valid regular expression.
 *								As and array: array('check' => value, 'regex' => 'valid regular expression')
 * @param string $regex If $check is passed as a string, $regex must also be set to valid regular expression
 * @return boolean Success
 * @access public
 */
	function custom($check, $regex = null) {
		$_this =& validator::getInstance();
		$_this->__reset();
		$_this->check = $check;
		$_this->regex = $regex;
		if (is_array($check)) {
			$_this->_extract($check);
		}
		if ($_this->regex === null) {
			$_this->errors[] = __('You must define a regular expression for validator::custom()', true);
			return false;
		}
		return $_this->_check();
	}

/**
 * Date validation, determines if the string passed is a valid date.
 * keys that expect full month, day and year will validate leap years
 *
 * @param string $check a valid date string
 * @param mixed $format Use a string or an array of the keys below. Arrays should be passed as array('dmy', 'mdy', etc)
 * 					Keys: dmy 27-12-2006 or 27-12-06 separators can be a space, period, dash, forward slash
 * 							mdy 12-27-2006 or 12-27-06 separators can be a space, period, dash, forward slash
 * 							ymd 2006-12-27 or 06-12-27 separators can be a space, period, dash, forward slash
 * 							dMy 27 December 2006 or 27 Dec 2006
 * 							Mdy December 27, 2006 or Dec 27, 2006 comma is optional
 * 							My December 2006 or Dec 2006
 * 							my 12/2006 separators can be a space, period, dash, forward slash
 * @param string $regex If a custom regular expression is used this is the only validation that will occur.
 * @return boolean Success
 * @access public
 */
	function date($check, $format = 'ymd', $regex = null) {
		$_this =& validator::getInstance();
		$_this->__reset();
		$_this->check = $check;
		$_this->regex = $regex;

		if (!is_null($_this->regex)) {
			return $_this->_check();
		}

		$regex['dmy'] = '%^(?:(?:31(\\/|-|\\.|\\x20)(?:0?[13578]|1[02]))\\1|(?:(?:29|30)(\\/|-|\\.|\\x20)(?:0?[1,3-9]|1[0-2])\\2))(?:(?:1[6-9]|[2-9]\\d)?\\d{2})$|^(?:29(\\/|-|\\.|\\x20)0?2\\3(?:(?:(?:1[6-9]|[2-9]\\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\\d|2[0-8])(\\/|-|\\.|\\x20)(?:(?:0?[1-9])|(?:1[0-2]))\\4(?:(?:1[6-9]|[2-9]\\d)?\\d{2})$%';
		$regex['mdy'] = '%^(?:(?:(?:0?[13578]|1[02])(\\/|-|\\.|\\x20)31)\\1|(?:(?:0?[13-9]|1[0-2])(\\/|-|\\.|\\x20)(?:29|30)\\2))(?:(?:1[6-9]|[2-9]\\d)?\\d{2})$|^(?:0?2(\\/|-|\\.|\\x20)29\\3(?:(?:(?:1[6-9]|[2-9]\\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:(?:0?[1-9])|(?:1[0-2]))(\\/|-|\\.|\\x20)(?:0?[1-9]|1\\d|2[0-8])\\4(?:(?:1[6-9]|[2-9]\\d)?\\d{2})$%';
		$regex['ymd'] = '%^(?:(?:(?:(?:(?:1[6-9]|[2-9]\\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00)))(\\/|-|\\.|\\x20)(?:0?2\\1(?:29)))|(?:(?:(?:1[6-9]|[2-9]\\d)?\\d{2})(\\/|-|\\.|\\x20)(?:(?:(?:0?[13578]|1[02])\\2(?:31))|(?:(?:0?[1,3-9]|1[0-2])\\2(29|30))|(?:(?:0?[1-9])|(?:1[0-2]))\\2(?:0?[1-9]|1\\d|2[0-8]))))$%';
		$regex['dMy'] = '/^((31(?!\\ (Feb(ruary)?|Apr(il)?|June?|(Sep(?=\\b|t)t?|Nov)(ember)?)))|((30|29)(?!\\ Feb(ruary)?))|(29(?=\\ Feb(ruary)?\\ (((1[6-9]|[2-9]\\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)))))|(0?[1-9])|1\\d|2[0-8])\\ (Jan(uary)?|Feb(ruary)?|Ma(r(ch)?|y)|Apr(il)?|Ju((ly?)|(ne?))|Aug(ust)?|Oct(ober)?|(Sep(?=\\b|t)t?|Nov|Dec)(ember)?)\\ ((1[6-9]|[2-9]\\d)\\d{2})$/';
		$regex['Mdy'] = '/^(?:(((Jan(uary)?|Ma(r(ch)?|y)|Jul(y)?|Aug(ust)?|Oct(ober)?|Dec(ember)?)\\ 31)|((Jan(uary)?|Ma(r(ch)?|y)|Apr(il)?|Ju((ly?)|(ne?))|Aug(ust)?|Oct(ober)?|(Sept|Nov|Dec)(ember)?)\\ (0?[1-9]|([12]\\d)|30))|(Feb(ruary)?\\ (0?[1-9]|1\\d|2[0-8]|(29(?=,?\\ ((1[6-9]|[2-9]\\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)))))))\\,?\\ ((1[6-9]|[2-9]\\d)\\d{2}))$/';
		$regex['My'] = '%^(Jan(uary)?|Feb(ruary)?|Ma(r(ch)?|y)|Apr(il)?|Ju((ly?)|(ne?))|Aug(ust)?|Oct(ober)?|(Sep(?=\\b|t)t?|Nov|Dec)(ember)?)[ /]((1[6-9]|[2-9]\\d)\\d{2})$%';
		$regex['my'] = '%^(((0[123456789]|10|11|12)([- /.])(([1][9][0-9][0-9])|([2][0-9][0-9][0-9]))))$%';

		$format = (is_array($format)) ? array_values($format) : array($format);
		foreach ($format as $key) {
			$_this->regex = $regex[$key];

			if ($_this->_check() === true) {
				return true;
			}
		}
		return false;
	}

/**
 * Time validation, determines if the string passed is a valid time.
 * Validates time as 24hr (HH:MM) or am/pm ([H]H:MM[a|p]m)
 * Does not allow/validate seconds.
 *
 * @param string $check a valid time string
 * @return boolean Success
 * @access public
 */

	function time($check) {
		$_this =& validator::getInstance();
		$_this->__reset();
		$_this->check = $check;
		$_this->regex = '%^((0?[1-9]|1[012])(:[0-5]\d){0,2}([AP]M|[ap]m))$|^([01]\d|2[0-3])(:[0-5]\d){0,2}$%';
		return $_this->_check();
	}

/**
 * Boolean validation, determines if value passed is a boolean integer or true/false.
 *
 * @param string $check a valid boolean
 * @return boolean Success
 * @access public
 */
	function boolean($check) {
		$booleanList = array(0, 1, '0', '1', true, false);
		return in_array($check, $booleanList, true);
	}

/**
 * Checks that a value is a valid decimal. If $places is null, the $check is allowed to be a scientific float
 * If no decimal point is found a false will be returned. Both the sign and exponent are optional.
 *
 * @param integer $check The value the test for decimal
 * @param integer $places if set $check value must have exactly $places after the decimal point
 * @param string $regex If a custom regular expression is used this is the only validation that will occur.
 * @return boolean Success
 * @access public
 */
	function decimal($check, $places = null, $regex = null) {
		$_this =& validator::getInstance();
		$_this->__reset();
		$_this->regex = $regex;
		$_this->check = $check;

		if (is_null($_this->regex)) {
			if (is_null($places)) {
				$_this->regex = '/^[-+]?[0-9]*\\.{1}[0-9]+(?:[eE][-+]?[0-9]+)?$/';
			} else {
				$_this->regex = '/^[-+]?[0-9]*\\.{1}[0-9]{'.$places.'}$/';
			}
		}
		return $_this->_check();
	}

/**
 * Validates for an email address.
 *
 * @param string $check Value to check
 * @param string $regex Regex to use (if none it will use built in regex)
 * @return boolean Success
 * @access public
 */
	function email($check, $regex = null) {
		$_this =& validator::getInstance();
		$_this->__reset();
		$_this->check = $check;
		$_this->regex = $regex;

		if (is_array($check)) {
			$_this->_extract($check);
		}

		if (is_null($_this->regex)) {
			$_this->regex = '/^[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@' . $_this->__pattern['hostname'] . '$/i';
		}
		$return = $_this->_check();

		if ($return === true && preg_match('/@(' . $_this->__pattern['hostname'] . ')$/i', $_this->check, $regs)) {
            return true;
		}
		return false;
	}

/**
 * Check that value is exactly $comparedTo.
 *
 * @param mixed $check Value to check
 * @param mixed $comparedTo Value to compare
 * @return boolean Success
 * @access public
 */
	function equalTo($check, $comparedTo) {
		return ($check === $comparedTo);
	}
    
/**
 * Check that value has a valid file extension.
 *
 * @param mixed $check Value to check
 * @param array $extensions file extenstions to allow
 * @return boolean Success
 * @access public
 */
	function extension($check, $extensions = array('gif', 'jpeg', 'png', 'jpg')) {
		if (is_array($check)) {
			return validator::extension(array_shift($check), $extensions);
		}
		$extension = strtolower(array_pop(explode('.', $check)));
		foreach ($extensions as $value) {
			if ($extension == strtolower($value)) {
				return true;
			}
		}
		return false;
	}

/**
 * Validation of an IP address.
 *
 * Valid IP version strings for type restriction are:
 * - both: Check both IPv4 and IPv6, return true if the supplied address matches either version
 * - IPv4: Version 4 (Eg: 127.0.0.1, 192.168.10.123, 203.211.24.8)
 * - IPv6: Version 6 (Eg: ::1, 2001:0db8::1428:57ab)
 *
 * @param string $check The string to test.
 * @param string $type The IP Version to test against
 * @return boolean Success
 * @access public
 */
	function ip($check, $type = 'both') {
		$_this =& validator::getInstance();
		$success = false;
		$type = strtolower($type);
		if ($type === 'ipv4' || $type === 'both') {
			$success |= $_this->_ipv4($check);
		}
		if ($type === 'ipv6' || $type === 'both') {
			$success |= $_this->_ipv6($check);
		}
		return $success;
	}

/**
 * Validation of IPv4 addresses.
 *
 * @param string $check IP Address to test
 * @return boolean Success
 * @access protected
 */
	function _ipv4($check) {
		if (function_exists('filter_var')) {
			return filter_var($check, FILTER_VALIDATE_IP, array('flags' => FILTER_FLAG_IPV4)) !== false;
		}
		$this->__populateIp();
		$this->check = $check;
		$this->regex = '/^' . $this->__pattern['IPv4'] . '$/';
		return $this->_check();
	}

/**
 * Validation of IPv6 addresses.
 *
 * @param string $check IP Address to test
 * @return boolean Success
 * @access protected
 */
	function _ipv6($check) {
		if (function_exists('filter_var')) {
			return filter_var($check, FILTER_VALIDATE_IP, array('flags' => FILTER_FLAG_IPV6)) !== false;
		}
		$this->__populateIp();
		$this->check = $check;
		$this->regex = '/^' . $this->__pattern['IPv6'] . '$/';
		return $this->_check();
	}

/**
 * Checks whether the length of a string is greater or equal to a minimal length.
 *
 * @param string $check The string to test
 * @param integer $min The minimal string length
 * @return boolean Success
 * @access public
 */
	function minLength($check, $min) {
		$length = MBYTE_strlen($check);
		return ($length >= $min);
	}

/**
 * Checks whether the length of a string is smaller or equal to a maximal length..
 *
 * @param string $check The string to test
 * @param integer $max The maximal string length
 * @return boolean Success
 * @access public
 */
	function maxLength($check, $max) {
		$length = MBYTE_strlen($check);
		return ($length <= $max);
	}

/**
 * Validate a multiple select.
 *
 * Valid Options
 *
 * - in => provide a list of choices that selections must be made from
 * - max => maximun number of non-zero choices that can be made
 * - min => minimum number of non-zero choices that can be made
 *
 * @param mixed $check Value to check
 * @param mixed $options Options for the check.
 * @return boolean Success
 * @access public
 */
	function multiple($check, $options = array()) {
		$defaults = array('in' => null, 'max' => null, 'min' => null);
		$options = array_merge($defaults, $options);
		$check = array_filter((array)$check);
		if (empty($check)) {
			return false;
		}
		if ($options['max'] && count($check) > $options['max']) {
			return false;
		}
		if ($options['min'] && count($check) < $options['min']) {
			return false;
		}
		if ($options['in'] && is_array($options['in'])) {
			foreach ($check as $val) {
				if (!in_array($val, $options['in'])) {
					return false;
				}
			}
		}
		return true;
	}

/**
 * Checks if a value is numeric.
 *
 * @param string $check Value to check
 * @return boolean Succcess
 * @access public
 */
	function numeric($check) {
		return is_numeric($check);
	}

/**
 * Check that a value is a valid phone number.
 *
 * @param mixed $check Value to check (string or array)
 * @param string $regex Regular expression to use
 * @return boolean Success
 * @access public
 */
	function phone($check, $regex = null) {
		$_this =& validator::getInstance();
		$_this->check = $check;
		$_this->regex = $regex;
        
		if (is_array($check)) {
			$_this->_extract($check);
		}

		if (is_null($_this->regex)) {
            // includes all NANPA members. see http://en.wikipedia.org/wiki/North_American_Numbering_Plan#List_of_NANPA_countries_and_territories
            $_this->regex  = '/^(?:\+?1)?[-. ]?\\(?[2-9][0-8][0-9]\\)?[-. ]?[2-9][0-9]{2}[-. ]?[0-9]{4}$/';
		}
		
		return $_this->_check();
	}

/**
 * Validate that a number is in specified range.
 * if $lower and $upper are not set, will return true if
 * $check is a legal finite on this platform
 *
 * @param string $check Value to check
 * @param integer $lower Lower limit
 * @param integer $upper Upper limit
 * @return boolean Success
 * @access public
 */
	function range($check, $lower = null, $upper = null) {
		if (!is_numeric($check)) {
			return false;
		}
		if (isset($lower) && isset($upper)) {
			return ($check > $lower && $check < $upper);
		}
		return is_finite($check);
	}
	
/**
 * Checks that a string contains something
 *
 * Returns true if string contains any characters. Function added so
 * old validation would be bypassed.
 *
 * $check can be passed as an array:
 * array('check' => 'valueToCheck');
 *
 * @param mixed $check Value to check
 * @return boolean Success
 * @access public
 */
	function string($check) {
		$_this =& validator::getInstance();
		$_this->__reset();
		$_this->check = $check;

		if (is_array($check)) {
			$_this->_extract($check);
		}

		// No check is needed expect if something exists
		if (empty($_this->check) && $_this->check != '0') {
			return false;
		}
		
		return true;
	}
	
/**
 * Checks that a string contains either nothing or something
 *
 * Returns true if string contains nothing or any characters. Function added so
 * old validation would be bypassed.
 *
 * $check can be passed as an array:
 * array('check' => 'valueToCheck');
 *
 * @param mixed $check Value to check
 * @return boolean Success
 * @access public
 */
	function stringOrEmpty($check) {
		$_this =& validator::getInstance();
		$_this->__reset();
		$_this->check = $check;

		if (is_array($check)) {
			$_this->_extract($check);
		}
		
		// No check is needed since none or any values are fine.
		
		return true;
	}	
	
/**
 * Checks that a value is a valid URL according to http://www.w3.org/Addressing/URL/url-spec.txt
 *
 * The regex checks for the following component parts:
 *
 * - a valid, optional, scheme
 * - a valid ip address OR
 *   a valid domain name as defined by section 2.3.1 of http://www.ietf.org/rfc/rfc1035.txt
 *   with an optional port number
 * - an optional valid path
 * - an optional query string (get parameters)
 * - an optional fragment (anchor tag)
 *
 * @param string $check Value to check
 * @param boolean $strict Require URL to be prefixed by a valid scheme (one of http(s)/ftp(s)/file/news/gopher)
 * @return boolean Success
 * @access public
 */
	function url($check, $strict = false) {
		$_this =& validator::getInstance();
		$_this->__populateIp();
		$_this->check = $check;
		$validChars = '([' . preg_quote('!"$&\'()*+,-.@_:;=~') . '\/0-9a-z]|(%[0-9a-f]{2}))';
		$_this->regex = '/^(?:(?:https?|ftps?|file|news|gopher):\/\/)' . (!empty($strict) ? '' : '?') .
			'(?:' . $_this->__pattern['IPv4'] . '|\[' . $_this->__pattern['IPv6'] . '\]|' . $_this->__pattern['hostname'] . ')' .
			'(?::[1-9][0-9]{0,4})?' .
			'(?:\/?|\/' . $validChars . '*)?' .
			'(?:\?' . $validChars . '*)?' .
			'(?:#' . $validChars . '*)?$/i';
		return $_this->_check();
	}

/**
 * Checks if a value is in a given list.
 *
 * @param string $check Value to check
 * @param array $list List to check against
 * @param boolean $strict is set to TRUE then will also check the types of the $check. 
 * @return boolean Succcess
 * @access public
 */
	function inList($check, $list, $strict = false) {
		return in_array($check, $list, $strict);
	}

/**
 * Runs an user-defined validation.
 *
 * @param mixed $check value that will be validated in user-defined methods.
 * @param object $object class that holds validation method
 * @param string $method class method name for validation to run
 * @param array $args arguments to send to method
 * @return mixed user-defined class class method returns
 * @access public
 */
	function userDefined($check, $object, $method, $args = null) {
		return call_user_func_array(array(&$object, $method), array($check, $args));
	}

/**
 * Runs a regular expression match.
 *
 * @return boolean Success of match
 * @access protected
 */
	function _check() {
		$_this =& validator::getInstance();
		if (preg_match($_this->regex, $_this->check)) {
			$_this->error[] = false;
			return true;
		} else {
			$_this->error[] = true;
			return false;
		}
	}

/**
 * Get the values to use when value sent to validation method is
 * an array.
 *
 * @param array $params Parameters sent to validation method
 * @return void
 * @access protected
 */
	function _extract($params) {
		$_this =& validator::getInstance();
		extract($params, EXTR_OVERWRITE);

		if (isset($check)) {
			$_this->check = $check;
		}
		if (isset($regex)) {
			$_this->regex = $regex;
		}
		if (isset($type)) {
			$_this->type = $type;
		}
	}

/*
 * Lazily popualate the IP address patterns used for validations
 *
 * @return void
 * @access private
 */
	function __populateIp() {
		if (!isset($this->__pattern['IPv6'])) {
			$pattern  = '((([0-9A-Fa-f]{1,4}:){7}(([0-9A-Fa-f]{1,4})|:))|(([0-9A-Fa-f]{1,4}:){6}';
			$pattern .= '(:|((25[0-5]|2[0-4]\d|[01]?\d{1,2})(\.(25[0-5]|2[0-4]\d|[01]?\d{1,2})){3})';
			$pattern .= '|(:[0-9A-Fa-f]{1,4})))|(([0-9A-Fa-f]{1,4}:){5}((:((25[0-5]|2[0-4]\d|[01]?\d{1,2})';
			$pattern .= '(\.(25[0-5]|2[0-4]\d|[01]?\d{1,2})){3})?)|((:[0-9A-Fa-f]{1,4}){1,2})))|(([0-9A-Fa-f]{1,4}:)';
			$pattern .= '{4}(:[0-9A-Fa-f]{1,4}){0,1}((:((25[0-5]|2[0-4]\d|[01]?\d{1,2})(\.(25[0-5]|2[0-4]\d|[01]?\d{1,2}))';
			$pattern .= '{3})?)|((:[0-9A-Fa-f]{1,4}){1,2})))|(([0-9A-Fa-f]{1,4}:){3}(:[0-9A-Fa-f]{1,4}){0,2}';
			$pattern .= '((:((25[0-5]|2[0-4]\d|[01]?\d{1,2})(\.(25[0-5]|2[0-4]\d|[01]?\d{1,2})){3})?)|';
			$pattern .= '((:[0-9A-Fa-f]{1,4}){1,2})))|(([0-9A-Fa-f]{1,4}:){2}(:[0-9A-Fa-f]{1,4}){0,3}';
			$pattern .= '((:((25[0-5]|2[0-4]\d|[01]?\d{1,2})(\.(25[0-5]|2[0-4]\d|[01]?\d{1,2}))';
			$pattern .= '{3})?)|((:[0-9A-Fa-f]{1,4}){1,2})))|(([0-9A-Fa-f]{1,4}:)(:[0-9A-Fa-f]{1,4})';
			$pattern .= '{0,4}((:((25[0-5]|2[0-4]\d|[01]?\d{1,2})(\.(25[0-5]|2[0-4]\d|[01]?\d{1,2})){3})?)';
			$pattern .= '|((:[0-9A-Fa-f]{1,4}){1,2})))|(:(:[0-9A-Fa-f]{1,4}){0,5}((:((25[0-5]|2[0-4]';
			$pattern .= '\d|[01]?\d{1,2})(\.(25[0-5]|2[0-4]\d|[01]?\d{1,2})){3})?)|((:[0-9A-Fa-f]{1,4})';
			$pattern .= '{1,2})))|(((25[0-5]|2[0-4]\d|[01]?\d{1,2})(\.(25[0-5]|2[0-4]\d|[01]?\d{1,2})){3})))(%.+)?';

			$this->__pattern['IPv6'] = $pattern;
		}
		if (!isset($this->__pattern['IPv4'])) {
			$pattern = '(?:(?:25[0-5]|2[0-4][0-9]|(?:(?:1[0-9])?|[1-9]?)[0-9])\.){3}(?:25[0-5]|2[0-4][0-9]|(?:(?:1[0-9])?|[1-9]?)[0-9])';
			$this->__pattern['IPv4'] = $pattern;
		}
	}

/**
 * Reset internal variables for another validation run.
 *
 * @return void
 * @access private
 */
	function __reset() {
		$this->check = null;
		$this->regex = null;
		$this->type = null;
		$this->error = array();
		$this->errors = array();
	}
}
?>
