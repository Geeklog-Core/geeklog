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


// for compatibility with versions of php without http_build_query
// from http://php.net/manual/en/function.http-build-query.php#52789
// Note: It does not work with complex arrays.
if (!function_exists('http_build_query')) {
   function http_build_query($formdata, $numeric_prefix = "")
   {
       $arr = array();
       foreach ($formdata as $key => $val)
         $arr[] = urlencode($numeric_prefix.$key)."=".urlencode($val);
       return implode($arr, '&');
   }
}


class oidUtil {

    function hmacsha1( $key, $text ) {
        return oidUtilPhpSha1::hmacsha1( $key, $text );
    }

    function sha1( $s ) {
        return oidUtilPhpSha1::sha1( $s );
    }
    
    // Note: in php we don't really convert to a long because php doesn't
    // support values this large.
    // 
    // instead we return a string converted from hex to base 10.
    function a2long($l) {
    
        $len = strlen($l);
        // transform bytes/char values into hex number
        $foo = unpack("H".(2*$len), $l);
        $hex = array_pop($foo);

        return oidUtilPhpBigInt::base_convert( $hex, 16, 10 );
    }


    // Note: in php we aren't really expecting a long as input.
    // Rather we expect a string containing a base 10 number.
    // 
    // we return a packed (byte) string containing a base 16 number.
    function long2a($a) {

        $hex = oidUtilPhpBigInt::base_convert( $a, 10, 16 );

        // pad
        if (strlen($hex) % 2) {
         $hex = "0" . $hex;   // pad leading hex nibble
        }
        if (ord($hex[0]) >= ord('8')) {
         $hex = "00" . $hex;  // pad if it looks like negative number 
        }
        // into bytestream
        return pack("H*", $hex);
    
    }
    
    function to_b64($s) {
        // Represent string s as base64, omitting newlines
        return base64_encode($s);
    }
    
    function from_b64($s) {
        return base64_decode($s);
    }    
    
    function kvform($ma) {
    
        // Represent mapped array ma as newline-terminated key:value pairs
        $str = '';
        foreach( $ma as $key => $val ) {
            $str .= sprintf( "%s:%s\n", $key, $val );
        }
        return $str;
    }    
    
    function parsekv( $d ) {
        $d = trim($d);
        $args = array();
        $lines = explode( "\n", $d );
        foreach( $lines as $line ) {
            $pair = explode( ':', $line, 2 );
            if( count($pair) != 2 ) {
                continue;
            }
            list($k,$v) = $pair;
            $args[trim($k)] = trim($v);
        }
        return $args;
    }
    
    function strxor( $aa, $bb ) {
    
        $buf = '';
        $len = min( strlen($aa), strlen($bb) );
        
        for ($i=0; $i<$len; $i++) {
          $buf .= chr( ord($aa[$i]) ^ ord($bb[$i]) );
        }
        return $buf;
    }
    
    function sign_reply($reply, $key, $signed_fields ) {
        // Sign the given fields from the reply with the specified key.
        // Return signed and sig
        
        $text = '';
        
        foreach( $signed_fields as $i ) {
            $val = $reply['openid.' . $i];
            $text .= sprintf( "%s:%s\n", $i, $val );
        }
        
        $sha1 = oidUtil::hmacsha1($key, $text);
        $b64_sha1 = oidUtil::to_b64( $sha1 );
        
        return array( implode( ',', $signed_fields ), $b64_sha1 );
    }
    
    function append_args( $url, $args ) {
        if( count($args) == 0 ) {
            return url;
        }
        $sep = strchr( $url, '?') ? '&' : '?';
        return sprintf('%s%s%s',  $url, $sep, http_build_query($args));
    }
    
    function random_string($length, $srand = null) {
    
        if( $srand ) {
            srand( $srand );
        }
    
        $a = '';
        for( $i = 0; $i < $length; $i++ ) {
            $a .= chr(rand(0,255));
        }
        return $a;
    }
    
    // PHP lacks these very handy string functions, startsWith and endsWith.
    // included here for easier porting from python.
    
    function startsWith( $str, $sub ) {
       return ( substr( $str, 0, strlen( $sub ) ) == $sub );
    }
    
    // return tru if $str ends with $sub
    function endsWith( $str, $sub ) {
       $len1 = strlen( $str );
       $len2 = strlen( $sub );
       return $len1 >= $len2 && ( substr( $str, $len1 - $len2 ) == $sub );
    }

};

// Porting note. This class does not exist in python.
// It was created to abstract the various implementations of sha1
// available ( or not available ) in php >= 4.x
class oidUtilPhpSha1 {

    // static 
    function hmacsha1( $key, $text ) {
        if( function_exists( 'mhash' ) ) {
            // yay, we have mhash!
            return mhash(MHASH_SHA1, $text, $key);
        }
        else {
            // do it ourselves.
            return oidUtilPhpSha1::_hmacsha1( $key, $text );
        }
    }
    
    // static
    function sha1( $s ) {
        if( function_exists( 'mhash' ) ) {
            // we have mhash, yay!
            return mhash(MHASH_SHA1, $s);
        }
        else if( function_exists( 'sha1' ) ) {
            // we have php's sha1, okie dokie
            if ((int)PHP_VERSION>=5) {
                return sha1($s, true);
            } else {
                // before php5, php does not support raw output.
                return pack("H*", sha1($s));
            }
        }
        else {
            // gotta do it ourselves.
            return oidUtilPhpSha1::_sha1_raw( $s );
        }
    }

    // private
    // adapted from from http://php.net/manual/en/function.sha1.php#39492
    // mark at dot BANSPAM dot pronexus dot nl
    function _hmacsha1($key,$data) {
       $blocksize=64;
       if (strlen($key)>$blocksize) {
           $key=oidUtilPhpSha1::sha1($key);
       }
       $key=str_pad($key,$blocksize,chr(0x00));
       $ipad=str_repeat(chr(0x36),$blocksize);
       $opad=str_repeat(chr(0x5c),$blocksize);
       $hmac = oidUtilPhpSha1::sha1( ($key^$opad) . oidUtilPhpSha1::sha1( ($key^$ipad) . $data ) );
       return $hmac;
    }    
    
    // private
    // php implementation of sha1, for older php versions. reportedly fast.
    // adapted from http://php.net/manual/en/function.sha1.php#48856
    // mina86 at tlen dot pl
	function _sha1_step(&$H, $str) {
		$A = $H[0]; $B = $H[1]; $C = $H[2]; $D = $H[3]; $E = $H[4];
		$W = array_values(unpack('N16', $str));
		for ($i = 0; $i<16; ++$i) {
			$W[$i+16] = &$W[$i];
		}

		$t = 0;
		do {		//  0 <= t < 20
			$s = $t & 0xf;
			if ($t>=16) {
				$W[$s] = oidUtilPhpSha1::_sha1_s($W[$s+13] ^ $W[$s+8] ^ $W[$s+ 2] ^ $W[$s]);
			}

			$TEMP = ($D ^ ($B & ($C ^ $D))) + 0x5A827999 +
				 oidUtilPhpSha1::_sha1_s($A, 5) + $E + $W[$s];
			$E = $D; $D = $C; $C = oidUtilPhpSha1::_sha1_s($B, 30); $B = $A; $A = $TEMP;
		} while (++$t<20);

		do {		// 20 <= t < 40
			$s = $t & 0xf;
			$W[$s] = oidUtilPhpSha1::_sha1_s($W[$s+13] ^ $W[$s+8] ^ $W[$s+ 2] ^ $W[$s]);

			$TEMP = ($B ^ $C ^ $D) + 0x6ED9EBA1 +
				 oidUtilPhpSha1::_sha1_s($A, 5) + $E + $W[$s];
			$E = $D; $D = $C; $C = oidUtilPhpSha1::_sha1_s($B, 30); $B = $A; $A = $TEMP;
		} while (++$t<40);

		do {		// 40 <= t < 60
			$s = $t & 0xf;
			$W[$s] = oidUtilPhpSha1::_sha1_s($W[$s+13] ^ $W[$s+8] ^ $W[$s+ 2] ^ $W[$s]);

			$TEMP = (($B & $C) | ($D & ($B | $C))) + 0x8F1BBCDC +
				 oidUtilPhpSha1::_sha1_s($A, 5) + $E + $W[$s];
			$E = $D; $D = $C; $C = oidUtilPhpSha1::_sha1_s($B, 30); $B = $A; $A = $TEMP;
		} while (++$t<60);

		do {		// 60 <= t < 80
			$s = $t & 0xf;
			$W[$s] = oidUtilPhpSha1::_sha1_s($W[$s+13] ^ $W[$s+8] ^ $W[$s+ 2] ^ $W[$s]);

			$TEMP = ($B ^ $C ^ $D) + 0xCA62C1D6 +
				 oidUtilPhpSha1::_sha1_s($A, 5) + $E + $W[$s];
			$E = $D; $D = $C; $C = oidUtilPhpSha1::_sha1_s($B, 30); $B = $A; $A = $TEMP;
		} while (++$t<80);

		$H = array($H[0] + $A, $H[1] + $B, $H[2] + $C, $H[3] + $D, $H[4] + $E);
	}

    // private
    // php implementation of sha1, for older php versions. reportedly fast.
    // adapted from http://php.net/manual/en/function.sha1.php#48856
    // mina86 at tlen dot pl
    function _sha1_s($X, $n = 1) {
		return ($X << $n) | (($X & 0x80000000)?
			 (($X>>1) & 0x07fffffff | 0x40000000)>>(31-$n):$X>>(32-$n));
	}

    // private
    // php implementation of sha1, for older php versions. reportedly fast.
    // adapted from http://php.net/manual/en/function.sha1.php#48856
    // mina86 at tlen dot pl
	function &_sha1_raw($str) {
		$l = strlen($str);
		$str = str_pad("$str\x80\0\0\0\0", ($l&~63)+((($l&63)<56)?60:124),
					   "\0") .  pack('N', $l<<3);
		$l = strlen($str);

		$H = array(0x67452301, 0xEFCDAB89, 0x98BADCFE, 0x10325476, 0xC3D2E1F0);
		for ($i = 0; $i<$l; $i += 64) {
			oidUtilPhpSha1::_sha1_step($H, substr($str, $i, 64));
		}

        $raw = pack('N*', $H[0], $H[1], $H[2], $H[3], $H[4]);
		return $raw;
	}
};


// Porting note. This class does not exist in python.
// It was created to abstract the various implementations of bigint
// available ( or not available ) in php >= 4.x
class oidUtilPhpBigInt {

    // static
    // adapted from xprofile's openlid
    //  http://xprofile.berlios.de/OpenLid
    function powm( $base, $exponent, $modulus ) {

        if( function_exists('gmp_powm')) {
            return gmp_strval(gmp_powm($base, $exponent, $modulus));
        }
        else if( function_exists('bi_powmod'))  {
            return bi_sto_str(bi_powmod($base, $exponent, $modulus));
        }
        else if( function_exists( 'bcpowmod' ) ) {
            return bcpowmod( $base, $exponent, $modulus );
        }
        // Warning: here we give up on php and call python or perl to help us out.
        // I'd like to replace this with native php code. Anyone know of
        // a good/fast implementation of powmod in php?
        // Anyway, if you don't want perl or python executed, comment out
        // this else clause.
        else if( preg_match("/^\d+,\d+,\d+$/", "$base,$exponent,$modulus")) {
            //@FIX: this is insecure - a bi-directional proc_open() is required
            if (is_executable("/usr/bin/python")) {
                $r = trim(`python -c "print pow($base, $exponent, $modulus)"`);
            }
            else {
                $r = trim(`perl -e "use Math::BigInt; print Math::BigInt->new('$base')->bmodpow('$exponent', '$modulus')->bstr();"`);
            }
            if (preg_match("/^\d+$/", $r)) {
                return($r);
            }
        }
        trigger_error("powmod: unsupported or non-integer argument", E_USER_ERROR);
    }

    // static
    function random( $minval ) {
    
        if( function_exists( 'gmp_random' ) ) {
            $limb_cnt = 31;
            do {
                $rdm = gmp_random($limb_cnt--);
            } while (gmp_cmp( $minval, $rdm) > 0);
            return gmp_strval($rdm);
        }
        else {
            // FIXME: does not honor minval
            return rand( 0, getrandmax() );
        }
    }

    // static
    function base_convert( $numstring, $frombase, $tobase ) {
    
        if ( function_exists('gmp_strval')) {
            return gmp_strval( gmp_init($numstring, $frombase), $tobase);
        }
        else if ( function_exists('bi_base_convert')) {
            return bi_base_convert($numstring, $frombase, $tobase );
        }
        else {
            return oidUtilPhpBigInt::_base_convert($numstring, $frombase, $tobase);
        }
    
    }
    
    // private
    //
    // From comment at http://php.net/manual/en/function.base-convert.php
    // by rithiur at mbnet dot fi
    //
    // Here is a simple function that can convert numbers of any size. 
    // However, note that as the division is performed manually to the 
    // number, this function is not very efficient and may not be suitable 
    // for converting strings with more than a few hundred numbers 
    // (depending on the number bases).
    function _base_convert($numstring, $frombase, $tobase)
    {
       $hex = '0123456789abcdef';
       $from_count = $frombase;
       $to_count = $tobase;
       $length = strlen($numstring);
       $result = '';
       $number = array();
       
       for ($i = 0; $i < $length; $i++)
       {
           $number[$i] = strpos($hex, $numstring{$i});
       }
       do // Loop until whole number is converted
       {
           $divide = 0;
           $newlen = 0;
           for ($i = 0; $i < $length; $i++) // Perform division manually (which is why this works with big numbers)
           {
               $divide = $divide * $from_count + $number[$i];
               if ($divide >= $to_count)
               {
                   $number[$newlen++] = (int)($divide / $to_count);
                   $divide = $divide % $to_count;
               }
               elseif ($newlen > 0)
               {
                   $number[$newlen++] = 0;
               }
           }
           $length = $newlen;

           $result = $hex{$divide} . $result; // Divide is basically $numstring % $to_count (i.e. the new character)
       }
       while ($newlen != 0);
       return $result;
    }
    
};

class DiffieHellman {

    var $DEFAULT_MOD = '155172898181473697471232257763715539915724801966915404479707795314057629378541917580651227423698188993727816152646631438561595825688188889951272158842675419950341258706556549803580104870537681476726513255747040765857479291291572334510643245094715007229621094194349783925984760375594985848253359305585439638443';
    var $DEFAULT_GEN = '2';
    
    var $p;
    var $g;
    var $x;
    
    // static
    function fromBase64( $p = null, $g = null, $srand = null ) {
    
        if( $p ) {
            $p = oidUtil::a2long(oidUtil::from_b64($p));
        }
        if( $g ) {
            $g = oidUtil::a2long(oidUtil::from_b64($g));
        }
        return new DiffieHellman($p, $g, $srand);
    }
    
    function DiffieHellman( $p = null, $g = null, $srand = null ) {
    
        $this->p = $p ? $p : $this->DEFAULT_MOD;
        $this->g = $g ? $g : $this->DEFAULT_GEN;
        
        if( $srand ) {
            $this->x = $srand;
        }
        else {
            $this->x = oidUtilPhpBigInt::random( $this->p );
        }
    }
    
    function createKeyExchange( ) {
    
        return oidUtilPhpBigInt::powm( $this->g, $this->x, $this->p);
    }

    function decryptKeyExchange( $keyEx ) {
    
        return oidUtilPhpBigInt::powm( $keyEx, $this->x, $this->p );
    
    }
    
}


?>
