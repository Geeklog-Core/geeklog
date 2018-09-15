<?php

/**
 * PHP implementation of the XML-RPC protocol
 * This is a PEAR-ified version of Useful inc's XML-RPC for PHP.
 * It has support for HTTP transport, proxies and authentication.
 * PHP versions 4 and 5
 *
 * @category   Web Services
 * @package    XML_RPC
 * @author     Edd Dumbill <edd@usefulinc.com>
 * @author     Stig Bakken <stig@php.net>
 * @author     Martin Jansen <mj@php.net>
 * @author     Daniel Convissor <danielc@php.net>
 * @copyright  1999-2001 Edd Dumbill, 2001-2010 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License
 * @version    SVN: $Id: RPC.php 315594 2011-08-27 01:03:57Z danielc $
 * @link       http://pear.php.net/package/XML_RPC
 */


if (!is_callable('xml_parser_create')) {
    throw new RuntimeException('XML extension is disabled!');
}

/**#@+
 * Error constants
 */
/**
 * Parameter values don't match parameter types
 */
define('XML_RPC_ERROR_INVALID_TYPE', 101);
/**
 * Parameter declared to be numeric but the values are not
 */
define('XML_RPC_ERROR_NON_NUMERIC_FOUND', 102);
/**
 * Communication error
 */
define('XML_RPC_ERROR_CONNECTION_FAILED', 103);
/**
 * The array or struct has already been started
 */
define('XML_RPC_ERROR_ALREADY_INITIALIZED', 104);
/**
 * Incorrect parameters submitted
 */
define('XML_RPC_ERROR_INCORRECT_PARAMS', 105);
/**
 * Programming error by developer
 */
define('XML_RPC_ERROR_PROGRAMMING', 106);
/**#@-*/

$GLOBALS = [];
/**
 * Data types
 *
 * @global string $GLOBALS ['XML_RPC_I4']
 */
$GLOBALS['XML_RPC_I4'] = 'i4';

/**
 * Data types
 *
 * @global string $GLOBALS ['XML_RPC_Int']
 */
$GLOBALS['XML_RPC_Int'] = 'int';

/**
 * Data types
 *
 * @global string $GLOBALS ['XML_RPC_Boolean']
 */
$GLOBALS['XML_RPC_Boolean'] = 'boolean';

/**
 * Data types
 *
 * @global string $GLOBALS ['XML_RPC_Double']
 */
$GLOBALS['XML_RPC_Double'] = 'double';

/**
 * Data types
 *
 * @global string $GLOBALS ['XML_RPC_String']
 */
$GLOBALS['XML_RPC_String'] = 'string';

/**
 * Data types
 *
 * @global string $GLOBALS ['XML_RPC_DateTime']
 */
$GLOBALS['XML_RPC_DateTime'] = 'dateTime.iso8601';

/**
 * Data types
 *
 * @global string $GLOBALS ['XML_RPC_Base64']
 */
$GLOBALS['XML_RPC_Base64'] = 'base64';

/**
 * Data types
 *
 * @global string $GLOBALS ['XML_RPC_Array']
 */
$GLOBALS['XML_RPC_Array'] = 'array';

/**
 * Data types
 *
 * @global string $GLOBALS ['XML_RPC_Struct']
 */
$GLOBALS['XML_RPC_Struct'] = 'struct';


/**
 * Data type meta-types
 *
 * @global array $GLOBALS ['XML_RPC_Types']
 */
$GLOBALS['XML_RPC_Types'] = array(
    $GLOBALS['XML_RPC_I4']       => 1,
    $GLOBALS['XML_RPC_Int']      => 1,
    $GLOBALS['XML_RPC_Boolean']  => 1,
    $GLOBALS['XML_RPC_String']   => 1,
    $GLOBALS['XML_RPC_Double']   => 1,
    $GLOBALS['XML_RPC_DateTime'] => 1,
    $GLOBALS['XML_RPC_Base64']   => 1,
    $GLOBALS['XML_RPC_Array']    => 2,
    $GLOBALS['XML_RPC_Struct']   => 3,
);


/**
 * Error message numbers
 *
 * @global array $GLOBALS ['XML_RPC_err']
 */
$GLOBALS['XML_RPC_err'] = array(
    'unknown_method'      => 1,
    'invalid_return'      => 2,
    'incorrect_params'    => 3,
    'introspect_unknown'  => 4,
    'http_error'          => 5,
    'not_response_object' => 6,
    'invalid_request'     => 7,
);

/**
 * Error message strings
 *
 * @global array $GLOBALS ['XML_RPC_str']
 */
$GLOBALS['XML_RPC_str'] = array(
    'unknown_method'      => 'Unknown method',
    'invalid_return'      => 'Invalid return payload: enable debugging to examine incoming payload',
    'incorrect_params'    => 'Incorrect parameters passed to method',
    'introspect_unknown'  => 'Can\'t introspect: method unknown',
    'http_error'          => 'Didn\'t receive 200 OK from remote server.',
    'not_response_object' => 'The requested method didn\'t return an XML_RPC_Response object.',
    'invalid_request'     => 'Invalid request payload',
);


/**
 * Default XML encoding (ISO-8859-1, UTF-8 or US-ASCII)
 *
 * @global string $GLOBALS ['XML_RPC_defencoding']
 */
$GLOBALS['XML_RPC_defencoding'] = 'UTF-8';

/**
 * User error codes start at 800
 *
 * @global int $GLOBALS ['XML_RPC_erruser']
 */
$GLOBALS['XML_RPC_erruser'] = 800;

/**
 * XML parse error codes start at 100
 *
 * @global int $GLOBALS ['XML_RPC_errxml']
 */
$GLOBALS['XML_RPC_errxml'] = 100;


/**
 * Compose backslashes for escaping regexp
 *
 * @global string $GLOBALS ['XML_RPC_backslash']
 */
$GLOBALS['XML_RPC_backslash'] = chr(92) . chr(92);


/**
 * Should we automatically base64 encode strings that contain characters
 * which can cause PHP's SAX-based XML parser to break?
 *
 * @global boolean $GLOBALS ['XML_RPC_auto_base64']
 */
$GLOBALS['XML_RPC_auto_base64'] = false;


/**
 * Valid parents of XML elements
 *
 * @global array $GLOBALS ['XML_RPC_valid_parents']
 */
$GLOBALS['XML_RPC_valid_parents'] = array(
    'BOOLEAN'          => array('VALUE'),
    'I4'               => array('VALUE'),
    'INT'              => array('VALUE'),
    'STRING'           => array('VALUE'),
    'DOUBLE'           => array('VALUE'),
    'DATETIME.ISO8601' => array('VALUE'),
    'BASE64'           => array('VALUE'),
    'ARRAY'            => array('VALUE'),
    'STRUCT'           => array('VALUE'),
    'PARAM'            => array('PARAMS'),
    'METHODNAME'       => array('METHODCALL'),
    'PARAMS'           => array('METHODCALL', 'METHODRESPONSE'),
    'MEMBER'           => array('STRUCT'),
    'NAME'             => array('MEMBER'),
    'DATA'             => array('ARRAY'),
    'FAULT'            => array('METHODRESPONSE'),
    'VALUE'            => array('MEMBER', 'DATA', 'PARAM', 'FAULT'),
);


/**
 * Stores state during parsing
 * quick explanation of components:
 *   + ac     = accumulates values
 *   + qt     = decides if quotes are needed for evaluation
 *   + cm     = denotes struct or array (comma needed)
 *   + isf    = indicates a fault
 *   + lv     = indicates "looking for a value": implements the logic
 *               to allow values with no types to be strings
 *   + params = stores parameters in method calls
 *   + method = stores method name
 *
 * @global array $GLOBALS ['XML_RPC_xh']
 */
$GLOBALS['XML_RPC_xh'] = array();


class XML_RPC
{
    /**
     * Return an ISO8601 encoded string
     * While timezones ought to be supported, the XML-RPC spec says:
     * "Don't assume a timezone. It should be specified by the server in its
     * documentation what assumptions it makes about timezones."
     * This routine always assumes localtime unless $utc is set to 1, in which
     * case UTC is assumed and an adjustment for locale is made when encoding.
     *
     * @return string  the formatted date
     */
    public static function XML_RPC_iso8601_encode($timet, $utc = 0)
    {
        if (!$utc) {
            $t = strftime('%Y%m%dT%H:%M:%S', $timet);
        } else {
            if (function_exists('gmstrftime')) {
                // gmstrftime doesn't exist in some versions of PHP
                $t = gmstrftime('%Y%m%dT%H:%M:%S', $timet);
            } else {
                $t = strftime('%Y%m%dT%H:%M:%S', $timet - date('Z'));
            }
        }

        return $t;
    }

    /**
     * Convert a datetime string into a Unix timestamp
     * While timezones ought to be supported, the XML-RPC spec says:
     * "Don't assume a timezone. It should be specified by the server in its
     * documentation what assumptions it makes about timezones."
     * This routine always assumes localtime unless $utc is set to 1, in which
     * case UTC is assumed and an adjustment for locale is made when encoding.
     *
     * @return int  the unix timestamp of the date submitted
     */
    public static function XML_RPC_iso8601_decode($idate, $utc = 0)
    {
        $t = 0;
        if (preg_match('@([0-9]{4})([0-9]{2})([0-9]{2})T([0-9]{2}):([0-9]{2}):([0-9]{2})@', $idate, $regs)) {
            if ($utc) {
                $t = gmmktime($regs[4], $regs[5], $regs[6], $regs[2], $regs[3], $regs[1]);
            } else {
                $t = mktime($regs[4], $regs[5], $regs[6], $regs[2], $regs[3], $regs[1]);
            }
        }

        return $t;
    }

    /**
     * Converts an XML_RPC_Value object into native PHP types
     *
     * @param  XML_RPC_Value $XML_RPC_val the object to decode
     * @return mixed  the PHP values
     * @throws InvalidArgumentException
     */
    public static function decode($XML_RPC_val)
    {
        $kind = $XML_RPC_val->kindOf();

        if ($kind === 'scalar') {
            return $XML_RPC_val->scalarval();
        } elseif ($kind == 'array') {
            $size = $XML_RPC_val->arraySize();
            $arr = array();
            for ($i = 0; $i < $size; $i++) {
                $arr[] = self::decode($XML_RPC_val->arrayMem($i));
            }

            return $arr;
        } elseif ($kind === 'struct') {
            $XML_RPC_val->structReset();
            $arr = array();
            while (list($key, $value) = $XML_RPC_val->structEach()) {
                $arr[$key] = self::decode($value);
            }

            return $arr;
        }

        throw new InvalidArgumentException(__METHOD__  . ': Unknown value type ' . $kind);
    }

    /**
     * Converts native PHP types into an XML_RPC_Value object
     *
     * @param mixed $php_val the PHP value or variable you want encoded
     * @return object  the XML_RPC_Value object
     */
    public static function encode($php_val)
    {
        $type = gettype($php_val);
        $XML_RPC_val = new XML_RPC_Value;

        switch ($type) {
            case 'array':
                if (empty($php_val)) {
                    $XML_RPC_val->addArray($php_val);
                    break;
                }
                $tmp = array_diff(array_keys($php_val), range(0, count($php_val) - 1));
                if (empty($tmp)) {
                    $arr = array();
                    foreach ($php_val as $k => $v) {
                        $arr[$k] = self::encode($v);
                    }
                    $XML_RPC_val->addArray($arr);
                    break;
                }
            // fall though if it's not an enumerated array

            case 'object':
                $arr = array();
                foreach ($php_val as $k => $v) {
                    $arr[$k] = self::encode($v);
                }
                $XML_RPC_val->addStruct($arr);
                break;

            case 'integer':
                $XML_RPC_val->addScalar($php_val, $GLOBALS['XML_RPC_Int']);
                break;

            case 'double':
                $XML_RPC_val->addScalar($php_val, $GLOBALS['XML_RPC_Double']);
                break;

            case 'string':
            case 'NULL':
                if (preg_match('@^[0-9]{8}\T{1}[0-9]{2}\:[0-9]{2}\:[0-9]{2}$@', $php_val)) {
                    $XML_RPC_val->addScalar($php_val, $GLOBALS['XML_RPC_DateTime']);
                } elseif ($GLOBALS['XML_RPC_auto_base64']
                    && preg_match("@[^ -~\t\r\n]@", $php_val)
                ) {
                    // Characters other than alpha-numeric, punctuation, SP, TAB,
                    // LF and CR break the XML parser, encode value via Base 64.
                    $XML_RPC_val->addScalar($php_val, $GLOBALS['XML_RPC_Base64']);
                } else {
                    $XML_RPC_val->addScalar($php_val, $GLOBALS['XML_RPC_String']);
                }
                break;

            case 'boolean':
                // Add support for encoding/decoding of booleans, since they
                // are supported in PHP
                // by <G_Giunta_2001-02-29>
                $XML_RPC_val->addScalar($php_val, $GLOBALS['XML_RPC_Boolean']);
                break;

            case 'unknown type':
            default:
                $XML_RPC_val = false;
        }

        return $XML_RPC_val;
    }

    /**
     * Start element handler for the XML parser
     *
     * @param  resource $parser_resource
     * @param  string   $name
     * @param  array    $attrs
     * @return void
     */
    public static function startElement($parser_resource, $name, array $attrs)
    {
        global $XML_RPC_xh, $XML_RPC_valid_parents;

        $parser = (int) $parser_resource;

        // if invalid xmlrpc already detected, skip all processing
        if ($XML_RPC_xh[$parser]['isf'] >= 2) {
            return;
        }

        // check for correct element nesting
        // top level element can only be of 2 types
        if (count($XML_RPC_xh[$parser]['stack']) == 0) {
            if ($name != 'METHODRESPONSE' && $name != 'METHODCALL') {
                $XML_RPC_xh[$parser]['isf'] = 2;
                $XML_RPC_xh[$parser]['isf_reason'] = 'missing top level xmlrpc element';

                return;
            }
        } else {
            // not top level element: see if parent is OK
            if (!in_array($XML_RPC_xh[$parser]['stack'][0], $XML_RPC_valid_parents[$name])) {
                $name = preg_replace('@[^a-zA-Z0-9._-]@', '', $name);
                $XML_RPC_xh[$parser]['isf'] = 2;
                $XML_RPC_xh[$parser]['isf_reason'] = "xmlrpc element $name cannot be child of {$XML_RPC_xh[$parser]['stack'][0]}";

                return;
            }
        }

        switch ($name) {
            case 'STRUCT':
                $XML_RPC_xh[$parser]['cm']++;

                // turn quoting off
                $XML_RPC_xh[$parser]['qt'] = 0;

                $cur_val = array();
                $cur_val['value'] = array();
                $cur_val['members'] = 1;
                array_unshift($XML_RPC_xh[$parser]['valuestack'], $cur_val);
                break;

            case 'ARRAY':
                $XML_RPC_xh[$parser]['cm']++;

                // turn quoting off
                $XML_RPC_xh[$parser]['qt'] = 0;

                $cur_val = array();
                $cur_val['value'] = array();
                $cur_val['members'] = 0;
                array_unshift($XML_RPC_xh[$parser]['valuestack'], $cur_val);
                break;

            case 'NAME':
                $XML_RPC_xh[$parser]['ac'] = '';
                break;

            case 'FAULT':
                $XML_RPC_xh[$parser]['isf'] = 1;
                break;

            case 'PARAM':
                $XML_RPC_xh[$parser]['valuestack'] = array();
                break;

            case 'VALUE':
                $XML_RPC_xh[$parser]['lv'] = 1;
                $XML_RPC_xh[$parser]['vt'] = $GLOBALS['XML_RPC_String'];
                $XML_RPC_xh[$parser]['ac'] = '';
                $XML_RPC_xh[$parser]['qt'] = 0;
                // look for a value: if this is still 1 by the
                // time we reach the first data segment then the type is string
                // by implication and we need to add in a quote
                break;

            case 'I4':
            case 'INT':
            case 'STRING':
            case 'BOOLEAN':
            case 'DOUBLE':
            case 'DATETIME.ISO8601':
            case 'BASE64':
                $XML_RPC_xh[$parser]['ac'] = ''; // reset the accumulator

                if ($name == 'DATETIME.ISO8601' || $name == 'STRING') {
                    $XML_RPC_xh[$parser]['qt'] = 1;

                    if ($name == 'DATETIME.ISO8601') {
                        $XML_RPC_xh[$parser]['vt'] = $GLOBALS['XML_RPC_DateTime'];
                    }

                } elseif ($name == 'BASE64') {
                    $XML_RPC_xh[$parser]['qt'] = 2;
                } else {
                    // No quoting is required here -- but
                    // at the end of the element we must check
                    // for data format errors.
                    $XML_RPC_xh[$parser]['qt'] = 0;
                }
                break;

            case 'MEMBER':
                $XML_RPC_xh[$parser]['ac'] = '';
                break;

            case 'DATA':
            case 'METHODCALL':
            case 'METHODNAME':
            case 'METHODRESPONSE':
            case 'PARAMS':
                // valid elements that add little to processing
                break;
        }


        // Save current element to stack
        array_unshift($XML_RPC_xh[$parser]['stack'], $name);

        if ($name != 'VALUE') {
            $XML_RPC_xh[$parser]['lv'] = 0;
        }
    }

    /**
     * End element handler for the XML parser
     *
     * @param  resource $parser_resource
     * @param  string   $name
     * @return void
     */
    public static function endElement($parser_resource, $name)
    {
        global $XML_RPC_xh;

        $parser = (int) $parser_resource;

        if ($XML_RPC_xh[$parser]['isf'] >= 2) {
            return;
        }

        // push this element from stack
        // NB: if XML validates, correct opening/closing is guaranteed and
        // we do not have to check for $name == $curr_elem.
        // we also checked for proper nesting at start of elements...
        $curr_elem = array_shift($XML_RPC_xh[$parser]['stack']);

        switch ($name) {
            case 'STRUCT':
            case 'ARRAY':
                $cur_val = array_shift($XML_RPC_xh[$parser]['valuestack']);
                $XML_RPC_xh[$parser]['value'] = $cur_val['value'];
                $XML_RPC_xh[$parser]['vt'] = strtolower($name);
                $XML_RPC_xh[$parser]['cm']--;
                break;

            case 'NAME':
                $XML_RPC_xh[$parser]['valuestack'][0]['name'] = $XML_RPC_xh[$parser]['ac'];
                break;

            case 'BOOLEAN':
                // special case here: we translate boolean 1 or 0 into PHP
                // constants true or false
                if ($XML_RPC_xh[$parser]['ac'] == '1') {
                    $XML_RPC_xh[$parser]['ac'] = 'true';
                } else {
                    $XML_RPC_xh[$parser]['ac'] = 'false';
                }

                $XML_RPC_xh[$parser]['vt'] = strtolower($name);
            // Drop through intentionally.

            case 'I4':
            case 'INT':
            case 'STRING':
            case 'DOUBLE':
            case 'DATETIME.ISO8601':
            case 'BASE64':
                if ($XML_RPC_xh[$parser]['qt'] == 1) {
                    // we use double quotes rather than single so backslashification works OK
                    $XML_RPC_xh[$parser]['value'] = $XML_RPC_xh[$parser]['ac'];
                } elseif ($XML_RPC_xh[$parser]['qt'] == 2) {
                    $XML_RPC_xh[$parser]['value'] = base64_decode($XML_RPC_xh[$parser]['ac']);
                } elseif ($name == 'BOOLEAN') {
                    $XML_RPC_xh[$parser]['value'] = $XML_RPC_xh[$parser]['ac'];
                } else {
                    // we have an I4, INT or a DOUBLE
                    // we must check that only 0123456789-.<space> are characters here
                    if (!preg_match("@^[+-]?[0123456789 \t\.]+$@", $XML_RPC_xh[$parser]['ac'])) {
                        XML_RPC_Base::raiseErrorStatic('Non-numeric value received in INT or DOUBLE',
                            XML_RPC_ERROR_NON_NUMERIC_FOUND);
                        $XML_RPC_xh[$parser]['value'] = XML_RPC_ERROR_NON_NUMERIC_FOUND;
                    } else {
                        // it's ok, add it on
                        $XML_RPC_xh[$parser]['value'] = $XML_RPC_xh[$parser]['ac'];
                    }
                }

                $XML_RPC_xh[$parser]['ac'] = '';
                $XML_RPC_xh[$parser]['qt'] = 0;
                $XML_RPC_xh[$parser]['lv'] = 3; // indicate we've found a value
                break;

            case 'VALUE':
                if ($XML_RPC_xh[$parser]['vt'] == $GLOBALS['XML_RPC_String']) {
                    if (strlen($XML_RPC_xh[$parser]['ac']) > 0) {
                        $XML_RPC_xh[$parser]['value'] = $XML_RPC_xh[$parser]['ac'];
                    } elseif ($XML_RPC_xh[$parser]['lv'] == 1) {
                        // The <value> element was empty.
                        $XML_RPC_xh[$parser]['value'] = '';
                    }
                }

                $temp = new XML_RPC_Value($XML_RPC_xh[$parser]['value'], $XML_RPC_xh[$parser]['vt']);

                $cur_val = array_shift($XML_RPC_xh[$parser]['valuestack']);
                if (is_array($cur_val)) {
                    if ($cur_val['members'] == 0) {
                        $cur_val['value'][] = $temp;
                    } else {
                        $XML_RPC_xh[$parser]['value'] = $temp;
                    }
                    array_unshift($XML_RPC_xh[$parser]['valuestack'], $cur_val);
                } else {
                    $XML_RPC_xh[$parser]['value'] = $temp;
                }
                break;

            case 'MEMBER':
                $XML_RPC_xh[$parser]['ac'] = '';
                $XML_RPC_xh[$parser]['qt'] = 0;

                $cur_val = array_shift($XML_RPC_xh[$parser]['valuestack']);
                if (is_array($cur_val)) {
                    if ($cur_val['members'] == 1) {
                        $cur_val['value'][$cur_val['name']] = $XML_RPC_xh[$parser]['value'];
                    }
                    array_unshift($XML_RPC_xh[$parser]['valuestack'], $cur_val);
                }
                break;

            case 'DATA':
                $XML_RPC_xh[$parser]['ac'] = '';
                $XML_RPC_xh[$parser]['qt'] = 0;
                break;

            case 'PARAM':
                $XML_RPC_xh[$parser]['params'][] = $XML_RPC_xh[$parser]['value'];
                break;

            case 'METHODNAME':
            case 'RPCMETHODNAME':
                $XML_RPC_xh[$parser]['method'] = preg_replace("@^[\n\r\t ]+@", '',
                    $XML_RPC_xh[$parser]['ac']);
                break;
        }

        // if it's a valid type name, set the type
        if (isset($GLOBALS['XML_RPC_Types'][strtolower($name)])) {
            $XML_RPC_xh[$parser]['vt'] = strtolower($name);
        }
    }

    /**
     * Character data handler for the XML parser
     *
     * @param  resource $parser_resource
     * @param  mixed    $data
     * @return void
     */
    public static function cd($parser_resource, $data)
    {
        global $XML_RPC_xh;

        $parser = (int) $parser_resource;

        if ($XML_RPC_xh[$parser]['lv'] != 3) {
            // "lookforvalue==3" means that we've found an entire value
            // and should discard any further character data

            if ($XML_RPC_xh[$parser]['lv'] == 1) {
                // if we've found text and we're just in a <value> then
                // turn quoting on, as this will be a string
                $XML_RPC_xh[$parser]['qt'] = 1;
                // and say we've found a value
                $XML_RPC_xh[$parser]['lv'] = 2;
            }

            // replace characters that eval would
            // do special things with
            if (!isset($XML_RPC_xh[$parser]['ac'])) {
                $XML_RPC_xh[$parser]['ac'] = '';
            }
            $XML_RPC_xh[$parser]['ac'] .= $data;
        }
    }
}

/**
 * The common methods and properties for all of the XML_RPC classes
 *
 * @category   Web Services
 * @package    XML_RPC
 * @author     Edd Dumbill <edd@usefulinc.com>
 * @author     Stig Bakken <stig@php.net>
 * @author     Martin Jansen <mj@php.net>
 * @author     Daniel Convissor <danielc@php.net>
 * @copyright  1999-2001 Edd Dumbill, 2001-2010 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License
 * @version    Release: @package_version@
 * @link       http://pear.php.net/package/XML_RPC
 */
class XML_RPC_Base
{
    /**
     * PEAR Error handling
     *
     * @param  string $msg
     * @param  int    $code
     * @return PEAR_Error
     */
    public function raiseError($msg, $code)
    {
        return PEAR::raiseError(get_class($this) . ': ' . $msg, $code);
    }

    /**
     * PEAR Error handling
     *
     * @param  string $msg
     * @param  int    $code
     * @return PEAR_Error
     */
    public static function raiseErrorStatic($msg, $code)
    {
        return PEAR::raiseError('XML_RPC: ' . $msg, $code);
    }

    /**
     * Tell whether something is a PEAR_Error object
     *
     * @param mixed $value the item to check
     * @return bool  whether $value is a PEAR_Error object or not
     */
    public function isError($value)
    {
        return is_object($value) && is_a($value, 'PEAR_Error');
    }
}

/**
 * The methods and properties for submitting XML RPC requests
 *
 * @category   Web Services
 * @package    XML_RPC
 * @author     Edd Dumbill <edd@usefulinc.com>
 * @author     Stig Bakken <stig@php.net>
 * @author     Martin Jansen <mj@php.net>
 * @author     Daniel Convissor <danielc@php.net>
 * @copyright  1999-2001 Edd Dumbill, 2001-2010 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License
 * @version    Release: @package_version@
 * @link       http://pear.php.net/package/XML_RPC
 */
class XML_RPC_Client extends XML_RPC_Base
{
    /**
     * The path and name of the RPC server script you want the request to go to
     *
     * @var string
     */
    private $path = '';

    /**
     * The name of the remote server to connect to
     *
     * @var string
     */
    private $server = '';

    /**
     * The protocol to use in contacting the remote server
     *
     * @var string
     */
    private $protocol = 'http://';

    /**
     * The port for connecting to the remote server
     * The default is 80 for http:// connections
     * and 443 for https:// and ssl:// connections.
     *
     * @var integer
     */
    private $port = 80;

    /**
     * A user name for accessing the RPC server
     *
     * @var string
     * @see XML_RPC_Client::setCredentials()
     */
    private $userName = '';

    /**
     * A password for accessing the RPC server
     *
     * @var string
     * @see XML_RPC_Client::setCredentials()
     */
    private $password = '';

    /**
     * The name of the proxy server to use, if any
     *
     * @var string
     */
    private $proxy = '';

    /**
     * The protocol to use in contacting the proxy server, if any
     *
     * @var string
     */
    private $proxyProtocol = 'http://';

    /**
     * The port for connecting to the proxy server
     * The default is 8080 for http:// connections
     * and 443 for https:// and ssl:// connections.
     *
     * @var integer
     */
    private $proxyPort = 8080;

    /**
     * A user name for accessing the proxy server
     *
     * @var string
     */
    private $proxyUser = '';

    /**
     * A password for accessing the proxy server
     *
     * @var string
     */
    private $proxyPass = '';

    /**
     * The error number, if any
     *
     * @var integer
     */
    private $errNo = 0;

    /**
     * The error message, if any
     *
     * @var string
     */
    private $errString = '';

    /**
     * The current debug mode (1 = on, 0 = off)
     *
     * @var integer
     */
    private $debug = 0;

    /**
     * The HTTP headers for the current request.
     *
     * @var string
     */
    private $headers = '';

    /**
     * Sets the object's properties
     *
     * @param string  $path         the path and name of the RPC server script
     *                              you want the request to go to
     * @param string  $server       the URL of the remote server to connect to.
     *                              If this parameter doesn't specify a
     *                              protocol and $port is 443, ssl:// is
     *                              assumed.
     * @param integer $port         a port for connecting to the remote server.
     *                              Defaults to 80 for http:// connections and
     *                              443 for https:// and ssl:// connections.
     * @param string  $proxy        the URL of the proxy server to use, if any.
     *                              If this parameter doesn't specify a
     *                              protocol and $port is 443, ssl:// is
     *                              assumed.
     * @param integer $proxyPort    a port for connecting to the remote server.
     *                              Defaults to 8080 for http:// connections and
     *                              443 for https:// and ssl:// connections.
     * @param string  $proxyUser    a user name for accessing the proxy server
     * @param string  $proxyPass    a password for accessing the proxy server
     */
    public function __construct($path, $server, $port = 0, $proxy = '', $proxyPort = 0, $proxyUser = '', $proxyPass = '')
    {
        $this->path = $path;
        $this->proxyUser = $proxyUser;
        $this->proxyPass = $proxyPass;

        preg_match('@^(http://|https://|ssl://)?(.*)$@', $server, $match);

        if ($match[1] == '') {
            if ($port == 443) {
                $this->server = $match[2];
                $this->protocol = 'ssl://';
                $this->port = 443;
            } else {
                $this->server = $match[2];
                if ($port) {
                    $this->port = $port;
                }
            }
        } elseif ($match[1] === 'http://') {
            $this->server = $match[2];
            if ($port) {
                $this->port = $port;
            }
        } else {
            $this->server = $match[2];
            $this->protocol = 'ssl://';
            if ($port) {
                $this->port = $port;
            } else {
                $this->port = 443;
            }
        }

        if ($proxy) {
            preg_match('@^(http://|https://|ssl://)?(.*)$@', $proxy, $match);

            if ($match[1] == '') {
                if ($proxyPort == 443) {
                    $this->proxy = $match[2];
                    $this->proxyProtocol = 'ssl://';
                    $this->proxyPort = 443;
                } else {
                    $this->proxy = $match[2];
                    if ($proxyPort) {
                        $this->proxyPort = $proxyPort;
                    }
                }
            } elseif ($match[1] === 'http://') {
                $this->proxy = $match[2];
                if ($proxyPort) {
                    $this->proxyPort = $proxyPort;
                }
            } else {
                $this->proxy = $match[2];
                $this->proxyProtocol = 'ssl://';
                if ($proxyPort) {
                    $this->proxyPort = $proxyPort;
                } else {
                    $this->proxyPort = 443;
                }
            }
        }
    }

    /**
     * Change the current debug mode
     *
     * @param int $in where 1 = on, 0 = off
     * @return void
     */
    public function setDebug($in)
    {
        $this->debug = $in ? 1 : 0;
    }

    /**
     * @return string
     */
    public function getErrorString()
    {
        return $this->errString;
    }

    /**
     * Sets whether strings that contain characters which may cause PHP's
     * SAX-based XML parser to break should be automatically base64 encoded
     * This is is a workaround for systems that don't have PHP's mbstring
     * extension available.
     *
     * @param  int $in where 1 = on, 0 = off
     * @return void
     */
    public function setAutoBase64($in)
    {
        $GLOBALS['XML_RPC_auto_base64'] = $in ? true : false;
    }

    /**
     * Set username and password properties for connecting to the RPC server
     *
     * @param  string $u the user name
     * @param  string $p the password
     * @return void
     * @see XML_RPC_Client::$userName, XML_RPC_Client::$password
     */
    public function setCredentials($u, $p)
    {
        $this->userName = $u;
        $this->password = $p;
    }

    /**
     * Transmit the RPC request via HTTP 1.0 protocol
     *
     * @param  XML_RPC_Message $msg     the XML_RPC_Message object
     * @param  int    $timeout how many seconds to wait for the request
     * @return XML_RPC_Response|int  0 is returned if any problems happen.
     * @see XML_RPC_Message, XML_RPC_Client::XML_RPC_Client(),
     *                        XML_RPC_Client::setCredentials()
     */
    public function send($msg, $timeout = 0)
    {
        if (!is_object($msg) || !is_a($msg, 'XML_RPC_Message')) {
            $this->errString = 'send()\'s $msg parameter must be an' . ' XML_RPC_Message object.';
            $this->raiseError($this->errString, XML_RPC_ERROR_PROGRAMMING);

            return 0;
        }

        $msg->setDebug($this->debug);

        return $this->sendPayloadHTTP10($msg, $this->server, $this->port,
            $timeout, $this->userName,
            $this->password);
    }

    /**
     * Transmit the RPC request via HTTP 1.0 protocol
     * Requests should be sent using XML_RPC_Client send() rather than
     * calling this method directly.
     *
     * @param XML_RPC_Message $msg      the XML_RPC_Message object
     * @param string          $server   the server to send the request to
     * @param int             $port     the server port send the request to
     * @param int             $timeout  how many seconds to wait for the request
     *                                  before giving up
     * @param string          $userName a user name for accessing the RPC server
     * @param string          $password a password for accessing the RPC server
     * @return XML_RPC_Response|int 0 is returned if any problems happen.
     * @see XML_RPC_Client::send()
     */
    protected function sendPayloadHTTP10(XML_RPC_Message $msg, $server, $port, $timeout = 0, $userName = '', $password = '')
    {
        // Preemptive BC hacks for fools calling sendPayloadHTTP10() directly
        if ($userName != $this->userName) {
            $this->setCredentials($userName, $password);
        }

        // Only create the payload if it was not created previously
        if (empty($msg->payload)) {
            $msg->createPayload();
        }
        $this->createHeaders($msg);

        $op = $this->headers . "\r\n\r\n";
        $op .= $msg->payload;

        if ($this->debug) {
            echo "\n<pre>---SENT---\n";
            echo $op;
            echo "\n---END---</pre>\n";
        }

        /*
         * If we're using a proxy open a socket to the proxy server
         * instead to the xml-rpc server
         */
        if ($this->proxy) {
            if ($this->proxyProtocol === 'http://') {
                $protocol = '';
            } else {
                $protocol = $this->proxyProtocol;
            }
            if ($timeout > 0) {
                $fp = @fsockopen($protocol . $this->proxy, $this->proxyPort,
                    $this->errNo, $this->errString, $timeout);
            } else {
                $fp = @fsockopen($protocol . $this->proxy, $this->proxyPort,
                    $this->errNo, $this->errString);
            }
        } else {
            if ($this->protocol === 'http://') {
                $protocol = '';
            } else {
                $protocol = $this->protocol;
            }

            if ($timeout > 0) {
                $fp = @fsockopen($protocol . $server, $port,
                    $this->errNo, $this->errString, $timeout);
            } else {
                $fp = @fsockopen($protocol . $server, $port,
                    $this->errNo, $this->errString);
            }
        }

        /*
         * Just raising the error without returning it is strange,
         * but keep it here for backwards compatibility.
         */
        if (!$fp && $this->proxy) {
            $this->raiseError('Connection to proxy server '
                . $this->proxy . ':' . $this->proxyPort
                . ' failed. ' . $this->errString,
                XML_RPC_ERROR_CONNECTION_FAILED);

            return 0;
        } elseif (!$fp) {
            $this->raiseError('Connection to RPC server '
                . $server . ':' . $port
                . ' failed. ' . $this->errString,
                XML_RPC_ERROR_CONNECTION_FAILED);

            return 0;
        }

        if ($timeout) {
            /*
             * Using socket_set_timeout() because stream_set_timeout()
             * was introduced in 4.3.0, but we need to support 4.2.0.
             */
            socket_set_timeout($fp, $timeout);
        }

        if (!fputs($fp, $op, strlen($op))) {
            $this->errString = 'Write error';

            return 0;
        }
        $resp = $msg->parseResponseFile($fp);

        $meta = socket_get_status($fp);
        if ($meta['timed_out']) {
            fclose($fp);
            $this->errString = 'RPC server did not send response before timeout.';
            $this->raiseError($this->errString, XML_RPC_ERROR_CONNECTION_FAILED);

            return 0;
        }

        fclose($fp);

        return $resp;
    }

    /**
     * Determines the HTTP headers and puts it in the $headers property
     *
     * @param object $msg the XML_RPC_Message object
     * @return boolean  TRUE if okay, FALSE if the message payload isn't set.
     */
    protected function createHeaders($msg)
    {
        if (empty($msg->payload)) {
            return false;
        }
        if ($this->proxy) {
            $this->headers = 'POST ' . $this->protocol . $this->server;
            if ($this->proxyPort) {
                $this->headers .= ':' . $this->port;
            }
        } else {
            $this->headers = 'POST ';
        }
        $this->headers .= $this->path . " HTTP/1.0\r\n";
        $this->headers .= "User-Agent: PEAR XML_RPC\r\n";
        $this->headers .= 'Host: ' . $this->server . "\r\n";

        if ($this->proxy && $this->proxyUser) {
            $this->headers .= 'Proxy-Authorization: Basic '
                . base64_encode("$this->proxyUser:$this->proxyPass")
                . "\r\n";
        }

        // thanks to Grant Rauscher <grant7@firstworld.net> for this
        if ($this->userName) {
            $this->headers .= 'Authorization: Basic '
                . base64_encode("{$this->userName}:{$this->password}")
                . "\r\n";
        }

        $this->headers .= "Content-Type: text/xml\r\n";
        $this->headers .= 'Content-Length: ' . strlen($msg->payload);

        return true;
    }
}

/**
 * The methods and properties for interpreting responses to XML RPC requests
 *
 * @category   Web Services
 * @package    XML_RPC
 * @author     Edd Dumbill <edd@usefulinc.com>
 * @author     Stig Bakken <stig@php.net>
 * @author     Martin Jansen <mj@php.net>
 * @author     Daniel Convissor <danielc@php.net>
 * @copyright  1999-2001 Edd Dumbill, 2001-2010 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License
 * @version    Release: @package_version@
 * @link       http://pear.php.net/package/XML_RPC
 */
class XML_RPC_Response extends XML_RPC_Base
{
    /**
     * @var int|XML_RPC_Value
     */
    private $value;

    /**
     * @var int
     */
    private $faultCode;

    /**
     * @var string
     */
    private $faultString;

    /**
     * @var array
     */
    private $headers = array();

    /**
     * XML_RPC_Response constructor.
     *
     * @param XML_RPC_Value|int $value
     * @param int               $faultCode
     * @param string            $faultString
     */
    public function __construct($value, $faultCode = 0, $faultString = '')
    {
        if ($faultCode != 0) {
            $this->faultCode = $faultCode;
            $this->faultString = htmlspecialchars($faultString);
        } else {
            $this->setValue($value);
        }
    }

    /**
     * @return int  the error code
     */
    public function faultCode()
    {
        return isset($this->faultCode) ? $this->faultCode : 0;
    }

    /**
     * @return string  the error string
     */
    public function faultString()
    {
        return $this->faultString;
    }

    /**
     * @return mixed  the value
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * Setter function
     *
     * @param XML_RPC_Value|int $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    /**
     * @return string  the error message in XML format
     */
    public function serialize()
    {
        $rs = "<methodResponse>\n";

        if ($this->faultCode) {
            $rs .= "<fault>
  <value>
    <struct>
      <member>
        <name>faultCode</name>
        <value><int>" . $this->faultCode . "</int></value>
      </member>
      <member>
        <name>faultString</name>
        <value><string>" . $this->faultString . "</string></value>
      </member>
    </struct>
  </value>
</fault>";
        } else {
            $rs .= "<params>\n<param>\n" . $this->value->serialize() .
                "</param>\n</params>";
        }

        $rs .= "\n</methodResponse>";

        return $rs;
    }
}

/**
 * The methods and properties for composing XML RPC messages
 *
 * @category   Web Services
 * @package    XML_RPC
 * @author     Edd Dumbill <edd@usefulinc.com>
 * @author     Stig Bakken <stig@php.net>
 * @author     Martin Jansen <mj@php.net>
 * @author     Daniel Convissor <danielc@php.net>
 * @copyright  1999-2001 Edd Dumbill, 2001-2010 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License
 * @version    Release: @package_version@
 * @link       http://pear.php.net/package/XML_RPC
 */
class XML_RPC_Message extends XML_RPC_Base
{
    /**
     * Should the payload's content be passed through mb_convert_encoding()?
     *
     * @see   XML_RPC_Message::setConvertPayloadEncoding()
     * @since Property available since Release 1.5.1
     * @var boolean
     */
    private $convert_payload_encoding = false;

    /**
     * The current debug mode (1 = on, 0 = off)
     *
     * @var integer
     */
    private $debug = 0;

    /**
     * The encoding to be used for outgoing messages
     * Defaults to the value of <var>$GLOBALS['XML_RPC_defencoding']</var>
     *
     * @var string
     * @see XML_RPC_Message::setSendEncoding(),
     *      $GLOBALS['XML_RPC_defencoding'], XML_RPC_Message::xml_header()
     */
    private $send_encoding = '';

    /**
     * The method presently being evaluated
     *
     * @var string
     */
    private $methodName = '';

    /**
     * @var array
     */
    private $params = array();

    /**
     * The XML message being generated
     *
     * @var string
     */
    public $payload = '';

    /**
     * Should extra line breaks be removed from the payload?
     *
     * @since Property available since Release 1.4.6
     * @var boolean
     */
    private $remove_extra_lines = true;

    /**
     * The XML response from the remote server
     *
     * @since Property available since Release 1.4.6
     * @var string
     */
    private $response_payload = '';

    /**
     * XML_RPC_Message constructor.
     *
     * @param  string $method
     * @param  array  $params
     */
    public function __construct($method, array $params = array())
    {
        $this->methodName = $method;

        if (count($params) > 0) {
            foreach ($params as $param) {
                $this->addParam($param);
            }
        }
    }

    /**
     * @param int $switch
     */
    public function setDebug($switch)
    {
        $this->debug = $switch ? 1 : 0;
    }

    /**
     * Produces the XML declaration including the encoding attribute
     * The encoding is determined by this class' <var>$send_encoding</var>
     * property.  If the <var>$send_encoding</var> property is not set, use
     * <var>$GLOBALS['XML_RPC_defencoding']</var>.
     *
     * @return string  the XML declaration and <methodCall> element
     * @see XML_RPC_Message::setSendEncoding(),
     *      XML_RPC_Message::$send_encoding, $GLOBALS['XML_RPC_defencoding']
     */
    private function xml_header()
    {
        global $XML_RPC_defencoding;

        if (!$this->send_encoding) {
            $this->send_encoding = $XML_RPC_defencoding;
        }

        return '<?xml version="1.0" encoding="' . $this->send_encoding . '"?>'
        . "\n<methodCall>\n";
    }

    /**
     * @return string  the closing </methodCall> tag
     */
    private function xml_footer()
    {
        return "</methodCall>\n";
    }

    /**
     * Fills the XML_RPC_Message::$payload property
     * Part of the process makes sure all line endings are in DOS format
     * (CRLF), which is probably required by specifications.
     * If XML_RPC_Message::setConvertPayloadEncoding() was set to true,
     * the payload gets passed through mb_convert_encoding()
     * to ensure the payload matches the encoding set in the
     * XML declaration.  The encoding type can be manually set via
     * XML_RPC_Message::setSendEncoding().
     *
     * @return void
     * @uses XML_RPC_Message::xml_header(), XML_RPC_Message::xml_footer()
     * @see  XML_RPC_Message::setSendEncoding(), $GLOBALS['XML_RPC_defencoding'],
     *      XML_RPC_Message::setConvertPayloadEncoding()
     */
    public function createPayload()
    {
        $this->payload = $this->xml_header()
            . '<methodName>' . $this->methodName . "</methodName>\n"
            . "<params>\n";

        foreach ($this->params as $param) {
            $this->payload .= "<param>\n" . $param->serialize() . "</param>\n";
        }

        $this->payload .= "</params>\n"
            . $this->xml_footer();

        if ($this->remove_extra_lines) {
            $this->payload = preg_replace("@[\r\n]+@", "\r\n", $this->payload);
        } else {
            $this->payload = preg_replace("@\r\n|\n|\r|\n\r@", "\r\n", $this->payload);
        }

        if ($this->convert_payload_encoding) {
            $this->payload = mb_convert_encoding($this->payload, $this->send_encoding);
        }
    }

    /**
     * @return string  the name of the method
     */
    public function method($method = '')
    {
        if ($method != '') {
            $this->methodName = $method;
        }

        return $this->methodName;
    }

    /**
     * @return string  the payload
     */
    public function serialize()
    {
        $this->createPayload();

        return $this->payload;
    }

    /**
     * @param mixed $param
     * @return void
     */
    public function addParam($param)
    {
        $this->params[] = $param;
    }

    /**
     * Obtains an XML_RPC_Value object for the given parameter
     *
     * @param int $i    the index number of the parameter to obtain
     * @return object  the XML_RPC_Value object.
     *                  If the parameter doesn't exist, an XML_RPC_Response object.
     * @since Returns XML_RPC_Response object on error since Release 1.3.0
     */
    public function getParam($i)
    {
        global $XML_RPC_err, $XML_RPC_str;

        if (isset($this->params[$i])) {
            return $this->params[$i];
        } else {
            $this->raiseError('The submitted request did not contain this parameter',
                XML_RPC_ERROR_INCORRECT_PARAMS);

            return new XML_RPC_Response(0, $XML_RPC_err['incorrect_params'],
                $XML_RPC_str['incorrect_params']);
        }
    }

    /**
     * @return int  the number of parameters
     */
    public function getNumParams()
    {
        return count($this->params);
    }

    /**
     * Sets whether the payload's content gets passed through
     * mb_convert_encoding()
     * Returns PEAR_ERROR object if mb_convert_encoding() isn't available.
     *
     * @param  int $in where 1 = on, 0 = off
     * @return mixed
     * @see    XML_RPC_Message::setSendEncoding()
     * @since  Method available since Release 1.5.1
     */
    private function setConvertPayloadEncoding($in)
    {
        if ($in && !function_exists('mb_convert_encoding')) {
            return $this->raiseError('mb_convert_encoding() is not available',
                XML_RPC_ERROR_PROGRAMMING);
        }

        $this->convert_payload_encoding = $in;

        return true;
    }

    /**
     * Sets the XML declaration's encoding attribute
     *
     * @param  string $type the encoding type (ISO-8859-1, UTF-8 or US-ASCII)
     * @return void
     * @see    XML_RPC_Message::setConvertPayloadEncoding(), XML_RPC_Message::xml_header()
     * @since  Method available since Release 1.2.0
     */
    private function setSendEncoding($type)
    {
        $this->send_encoding = $type;
    }

    /**
     * Determine the XML's encoding via the encoding attribute
     * in the XML declaration
     * If the encoding parameter is not set or is not ISO-8859-1, UTF-8
     * or US-ASCII, $XML_RPC_defencoding will be returned.
     *
     * @param  string $data the XML that will be parsed
     * @return string  the encoding to be used
     * @link   http://php.net/xml_parser_create
     * @since  Method available since Release 1.2.0
     */
    public static function getEncoding($data)
    {
        global $XML_RPC_defencoding;

        if (preg_match('@<\?xml[^>]*\s*encoding\s*=\s*[\'"]([^"\']*)[\'"]@',
            $data, $match)) {
            $match[1] = trim(strtoupper($match[1]));

            switch ($match[1]) {
                case 'ISO-8859-1':
                case 'UTF-8':
                case 'US-ASCII':
                    return $match[1];
                    break;

                default:
                    return $XML_RPC_defencoding;
            }
        } else {
            return $XML_RPC_defencoding;
        }
    }

    /**
     * @param  resource $fp
     * @return XML_RPC_Response
     */
    public function parseResponseFile($fp)
    {
        $ipd = '';

        while ($data = @fread($fp, 8192)) {
            $ipd .= $data;
        }

        return $this->parseResponse($ipd);
    }

    /**
     * @param  string $data
     * @return XML_RPC_Response
     */
    private function parseResponse($data = '')
    {
        global $XML_RPC_xh, $XML_RPC_err, $XML_RPC_str;

        $encoding = self::getEncoding($data);
        $parser_resource = xml_parser_create($encoding);
        $parser = (int) $parser_resource;

        $XML_RPC_xh = array();
        $XML_RPC_xh[$parser] = array();

        $XML_RPC_xh[$parser]['cm'] = 0;
        $XML_RPC_xh[$parser]['isf'] = 0;
        $XML_RPC_xh[$parser]['ac'] = '';
        $XML_RPC_xh[$parser]['qt'] = '';
        $XML_RPC_xh[$parser]['stack'] = array();
        $XML_RPC_xh[$parser]['valuestack'] = array();

        xml_parser_set_option($parser_resource, XML_OPTION_CASE_FOLDING, true);
        xml_set_element_handler($parser_resource, 'XML_RPC::startElement', 'XML_RPC::endElement');
        xml_set_character_data_handler($parser_resource, 'XML_RPC::cd');

        $hdrfnd = 0;
        if ($this->debug) {
            echo "\n<pre>---GOT---\n";
            echo isset($_SERVER['SERVER_PROTOCOL']) ? htmlspecialchars($data) : $data;
            echo "\n---END---</pre>\n";
        }

        // See if response is a 200 or a 100 then a 200, else raise error.
        // But only do this if we're using the HTTP protocol.
        if (preg_match('@^HTTP@', $data) &&
            !preg_match('@^HTTP/[0-9\.]+ 200 @', $data) &&
            !preg_match('@^HTTP/[0-9\.]+ 10[0-9]([A-Z ]+)?[\r\n]+HTTP/[0-9\.]+ 200@', $data)
        ) {
            $errorString = substr($data, 0, strpos($data, "\n") - 1);
            error_log('HTTP error, got response: ' . $errorString);
            $r = new XML_RPC_Response(0, $XML_RPC_err['http_error'],
                $XML_RPC_str['http_error'] . ' (' .
                $errorString . ')'
            );
            xml_parser_free($parser_resource);

            return $r;
        }

        // gotta get rid of headers here
        if (!$hdrfnd && ($brpos = strpos($data, "\r\n\r\n"))) {
            $XML_RPC_xh[$parser]['ha'] = substr($data, 0, $brpos);
            $data = substr($data, $brpos + 4);
            $hdrfnd = 1;
        }

        /*
         * be tolerant of junk after methodResponse
         * (e.g. javascript automatically inserted by free hosts)
         * thanks to Luca Mariano <luca.mariano@email.it>
         */
        $data = substr($data, 0, strpos($data, '</methodResponse>') + strlen('</methodResponse>'));
        $this->response_payload = $data;

        if (!xml_parse($parser_resource, $data, (strlen($data) > 0))) {
            // thanks to Peter Kocks <peter.kocks@baygate.com>
            if (xml_get_current_line_number($parser_resource) == 1) {
                $errorString = 'XML error at line 1, check URL';
            } else {
                $errorString = sprintf('XML error: %s at line %d',
                    xml_error_string(xml_get_error_code($parser_resource)),
                    xml_get_current_line_number($parser_resource));
            }
            error_log($errorString);
            $r = new XML_RPC_Response(0, $XML_RPC_err['invalid_return'],
                $XML_RPC_str['invalid_return']);
            xml_parser_free($parser_resource);

            return $r;
        }

        xml_parser_free($parser_resource);

        if ($this->debug) {
            echo "\n<pre>---PARSED---\n";
            var_dump($XML_RPC_xh[$parser]['value']);
            echo "---END---</pre>\n";
        }

        if ($XML_RPC_xh[$parser]['isf'] > 1) {
            $r = new XML_RPC_Response(0, $XML_RPC_err['invalid_return'],
                $XML_RPC_str['invalid_return'] . ' ' . $XML_RPC_xh[$parser]['isf_reason']);
        } elseif (!is_object($XML_RPC_xh[$parser]['value'])) {
            // then something odd has happened
            // and it's time to generate a client side error
            // indicating something odd went on
            $r = new XML_RPC_Response(0, $XML_RPC_err['invalid_return'],
                $XML_RPC_str['invalid_return']);
        } else {
            $v = $XML_RPC_xh[$parser]['value'];
            if ($XML_RPC_xh[$parser]['isf']) {
                $f = $v->structMem('faultCode');
                $fs = $v->structMem('faultString');
                $r = new XML_RPC_Response($v, $f->scalarval(), $fs->scalarval());
            } else {
                $r = new XML_RPC_Response($v);
            }
        }

        $r->setHeaders(preg_split("@\r?\n@", $XML_RPC_xh[$parser]['ha']));

        return $r;
    }
}

/**
 * The methods and properties that represent data in XML RPC format
 *
 * @category   Web Services
 * @package    XML_RPC
 * @author     Edd Dumbill <edd@usefulinc.com>
 * @author     Stig Bakken <stig@php.net>
 * @author     Martin Jansen <mj@php.net>
 * @author     Daniel Convissor <danielc@php.net>
 * @copyright  1999-2001 Edd Dumbill, 2001-2010 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License
 * @version    Release: @package_version@
 * @link       http://pear.php.net/package/XML_RPC
 */
class XML_RPC_Value extends XML_RPC_Base
{
    private $me = array();
    private $myType = 0;

    /**
     * XML_RPC_Value constructor.
     *
     * @param int    $val
     * @param string $type
     */
    public function __construct($val = -1, $type = '')
    {
        $this->me = array();
        $this->myType = 0;

        if ($val != -1 || $type != '') {
            if ($type === '') {
                $type = 'string';
            }
            if (!array_key_exists($type, $GLOBALS['XML_RPC_Types'])) {
                // XXX
                // need some way to report this error
            } elseif ($GLOBALS['XML_RPC_Types'][$type] == 1) {
                $this->addScalar($val, $type);
            } elseif ($GLOBALS['XML_RPC_Types'][$type] == 2) {
                $this->addArray($val);
            } elseif ($GLOBALS['XML_RPC_Types'][$type] == 3) {
                $this->addStruct($val);
            }
        }
    }

    /**
     * @param  mixed  $value
     * @param  string $type
     * @return int  returns 1 if successful or 0 if there are problems
     */
    public function addScalar($value, $type = 'string')
    {
        if ($this->myType == 1) {
            $this->raiseError('Scalar can have only one value',
                XML_RPC_ERROR_INVALID_TYPE);

            return 0;
        }
        $typeof = $GLOBALS['XML_RPC_Types'][$type];
        if ($typeof != 1) {
            $this->raiseError("Not a scalar type (${typeof})",
                XML_RPC_ERROR_INVALID_TYPE);

            return 0;
        }

        if ($type == $GLOBALS['XML_RPC_Boolean']) {
            if ((strcasecmp($value, 'true') === 0)
                || ($value == 1)
                || ($value == true && strcasecmp($value, 'false'))
            ) {
                $value = 1;
            } else {
                $value = 0;
            }
        }

        if ($this->myType == 2) {
            // we're adding to an array here
            $ar = $this->me['array'];
            $ar[] = new XML_RPC_Value($value, $type);
            $this->me['array'] = $ar;
        } else {
            // a scalar, so set the value and remember we're scalar
            $this->me[$type] = $value;
            $this->myType = $typeof;
        }

        return 1;
    }

    /**
     * @param  mixed $values
     * @return int  returns 1 if successful or 0 if there are problems
     */
    public function addArray($values)
    {
        if ($this->myType != 0) {
            $this->raiseError(
                'Already initialized as a [' . $this->kindOf() . ']',
                XML_RPC_ERROR_ALREADY_INITIALIZED
            );

            return 0;
        }

        $this->myType = $GLOBALS['XML_RPC_Types']['array'];
        $this->me['array'] = $values;

        return 1;
    }

    /**
     * @param  mixed $values
     * @return int  returns 1 if successful or 0 if there are problems
     */
    public function addStruct($values)
    {
        if ($this->myType != 0) {
            $this->raiseError(
                'Already initialized as a [' . $this->kindOf() . ']',
                XML_RPC_ERROR_ALREADY_INITIALIZED);

            return 0;
        }

        $this->myType = $GLOBALS['XML_RPC_Types']['struct'];
        $this->me['struct'] = $values;

        return 1;
    }

    /**
     * @param  array $array
     * @return void
     */
    public function dump($array)
    {
        foreach ($array as $key => $val) {
            echo "$key => $val<br />";
            if ($key === 'array') {
                foreach ($val as $key2 => $val2) {
                    echo "-- $key2 => $val2<br />";
                }
            }
        }
    }

    /**
     * @return string  the data type of the current value
     */
    public function kindOf()
    {
        switch ($this->myType) {
            case 3:
                return 'struct';

            case 2:
                return 'array';

            case 1:
                return 'scalar';

            default:
                return 'undef';
        }
    }

    /**
     * @param  string $type
     * @param  mixed  $val
     * @return string  the data in XML format
     */
    private function serializeData($type, $val)
    {
        $rs = '';
        if (!array_key_exists($type, $GLOBALS['XML_RPC_Types'])) {
            // XXX
            // need some way to report this error
            return null;
        }

        switch ($GLOBALS['XML_RPC_Types'][$type]) {
            case 3:
                // struct
                $rs .= "<struct>\n";

                foreach ($val as $key2 => $val2) {
                    $rs .= "<member><name>" . htmlspecialchars($key2) . "</name>\n";
                    $rs .= $this->serializeValue($val2);
                    $rs .= "</member>\n";
                }
                $rs .= '</struct>';
                break;

            case 2:
                // array
                $rs .= "<array>\n<data>\n";

                foreach ($val as $value) {
                    $rs .= $this->serializeValue($value);
                }
                $rs .= "</data>\n</array>";
                break;

            case 1:
                switch ($type) {
                    case $GLOBALS['XML_RPC_Base64']:
                        $rs .= "<${type}>" . base64_encode($val) . "</${type}>";
                        break;

                    case $GLOBALS['XML_RPC_Boolean']:
                        $rs .= "<${type}>" . ($val ? '1' : '0') . "</${type}>";
                        break;

                    case $GLOBALS['XML_RPC_String']:
                        $rs .= "<${type}>" . htmlspecialchars($val) . "</${type}>";
                        break;

                    default:
                        $rs .= "<${type}>${val}</${type}>";
                }
        }

        return $rs;
    }

    /**
     * @return string  the data in XML format
     */
    public function serialize()
    {
        return $this->serializeValue($this);
    }

    /**
     * @return string  the data in XML format
     */
    private function serializeValue($o)
    {
        if (!is_object($o) || empty($o->me) || !is_array($o->me)) {
            return '';
        }

        $ar = $o->me;
        reset($ar);
        list($typ, $val) = each($ar);

        return '<value>' . $this->serializeData($typ, $val) . "</value>\n";
    }

    /**
     * @return mixed  the contents of the element requested
     */
    public function structMem($m)
    {
        return $this->me['struct'][$m];
    }

    /**
     * @return void
     */
    public function structReset()
    {
        reset($this->me['struct']);
    }

    /**
     * @return  array the key/value pair of the struct's current element
     */
    public function structEach()
    {
        return each($this->me['struct']);
    }

    /**
     * @return mixed  the current value
     */
    public function getValue()
    {
        // UNSTABLE

        reset($this->me);
        $b = current($this->me);

        // contributed by I Sofer, 2001-03-24
        // add support for nested arrays to scalarval
        // i've created a new method here, so as to
        // preserve back compatibility

        if (is_array($b)) {
            foreach ($b as $id => $cont) {
                $b[$id] = $cont->scalarval();
            }
        }

        // add support for structures directly encoding php objects
        if (is_object($b)) {
            $t = get_object_vars($b);

            foreach ($t as $id => $cont) {
                $t[$id] = $cont->scalarval();
            }

            foreach ($t as $id => $cont) {
                $b->$id = $cont;
            }
        }

        // end contrib
        return $b;
    }

    /**
     * @return mixed  the current element's scalar value.  If the value is
     *                 not scalar, FALSE is returned.
     */
    public function scalarval()
    {
        reset($this->me);
        $v = current($this->me);
        if (!is_scalar($v)) {
            $v = false;
        }

        return $v;
    }

    /**
     * @return string
     */
    public function scalarTyp()
    {
        reset($this->me);
        $a = key($this->me);
        if ($a == $GLOBALS['XML_RPC_I4']) {
            $a = $GLOBALS['XML_RPC_Int'];
        }

        return $a;
    }

    /**
     * @return mixed  the struct's current element
     */
    public function arrayMem($m)
    {
        return $this->me['array'][$m];
    }

    /**
     * @return int  the number of elements in the array
     */
    public function arraySize()
    {
        reset($this->me);
        list(, $b) = each($this->me);

        return sizeof($b);
    }

    /**
     * Determines if the item submitted is an XML_RPC_Value object
     *
     * @param mixed $val the variable to be evaluated
     * @return bool  TRUE if the item is an XML_RPC_Value object
     * @static
     * @since Method available since Release 1.3.0
     */
    public static function isValue($val)
    {
        return (strtolower(get_class($val)) === 'xml_rpc_value');
    }
}
