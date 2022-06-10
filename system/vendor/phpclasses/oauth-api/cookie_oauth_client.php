<?php
/*
 * cookie_oauth_client.php
 *
 * @(#) $Id: cookie_oauth_client.php,v 1.7 2022/04/10 04:42:19 mlemos Exp $
 *
 */

class cookie_oauth_client_class extends oauth_client_class
{
	var $session = '';
	var $key = '';
	var $cookie_name = 'OAuth_session';
	var $cookie_value;
	var $cipher = '';
	var $openssl_default_cipher = 'bf-ofb';
	var $mcrypt_default_cipher = 'blowfish-compat-ofb';


	Function EncodeText($text, $context, &$error)
	{
		$error = '';
		$encode_time = time();
		$algorithm_mode = $this->cipher;
		if(function_exists('openssl_encrypt'))
		{
			if($algorithm_mode === '')
				$algorithm_mode = $this->openssl_default_cipher;
			$options = true;
			if(!($iv_size = openssl_cipher_iv_length($algorithm_mode)))
			{
				$ciphers = openssl_get_cipher_methods();
				if(in_array($cipher, $ciphers))
					$error = $this->GetError('it was not possible to get the length for an OpenSSL cipher '.$cipher.' for '.$context);
				else
				{
					$error = $this->GetError('the cipher '.$algorithm_mode.' is not made available by the OpenSSL extension of the current PHP installation. Use the openssl_get_cipher_methods function to discover which ciphers are available and set the Cipher property of the input managed by the '.__CLASS__.' class');
				}
				return '';
			}
			$iv = openssl_random_pseudo_bytes($iv_size);
			$key = $encode_time.$this->key;
			if(!($cipher = openssl_encrypt($text, $algorithm_mode, $key, $options, $iv)))
			{
				$error = $this->GetError('it was not possible to encrypt using OpenSSL a value for '.$context);
				return '';
			}
		}
		elseif(function_exists('mcrypt_encrypt'))
		{
			if($algorithm_mode === '')
				$algorithm_mode = $this->mcrypt_default_cipher;
			$last_hiphen = strrpos($algorithm_mode, '-');
			$algorithm = substr($algorithm_mode, 0, $last_hiphen);
			$mode = substr($algorithm_mode, $last_hiphen + 1);
			if(!($iv_size = @mcrypt_get_iv_size($algorithm, $mode)))
			{
				$algorithms = @mcrypt_list_algorithms();
				if(!in_array($algorithm, $algorithms))
				{
					$error = $this->GetError('the cipher algorithm '.$algorithm.' is not made available by the mcrypt extension of the current PHP installation. Set the Cipher property of the input managed by the '.__CLASS__.' class to any of these algorithms: '.implode(', ',$algorithms));
				}
				else
				{
					$modes = mcrypt_list_modes();
					if(!in_array($mode, $modes))
					{
						$error = $this->GetError('the cipher mode '.$mode.' for algorithm '.$algorithm.' is not made available by the mcrypt extension of the current PHP installation. Set the Cipher property of the input managed by the '.__CLASS__.' class to any of these modes for algorithm '.$algorithm.': '.implode(', ',$algorithms));
					}
					else
					{
						$error = 'the cipher '.$algorithm_mode.' is not made available by the mcrypt extension of the current PHP installation. Use the mcrypt_list_algorithms and mcrypt_list_modes functions to discover which algorithms and modes are available and set the Cipher property of the input managed by the '.__CLASS__.' class';
					}
				}
				return '';
			}
			$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
			$key = $this->FixKey($encode_time.$this->key);
			if(!($cipher = mcrypt_encrypt($algorithm, $key, $text, $mode, $iv)))
			{
				$error = $this->GetError('it was not possible to encrypt using mcrypt a value for '.$context);
				return '';
			}
		}
		else
		{
			$error = 'neither the mcrypt nor the OpenSSL extensions are available in this PHP installation'.$context;
			return '';
		}
		$encoded = base64_encode($iv.$cipher);
		$encoded = $encoded.':'.$encode_time;
		return $encoded;
	}

	Function DecodeText($encoded, &$encode_time, &$error)
	{
		$error = '';
		if(GetType($colon = strpos($encoded, ':')) != 'integer'
		|| ($encode_time = intval(substr($encoded, $colon + 1))) == 0
		|| $encode_time > time()
		|| !($encrypted = base64_decode($e = substr($encoded, 0, $colon))))
			return '';
		$algorithm_mode = $this->cipher;
		if(function_exists('openssl_decrypt'))
		{
			if($algorithm_mode === '')
				$algorithm_mode = $this->openssl_default_cipher;
			$options = true;
			$iv_size = openssl_cipher_iv_length($algorithm_mode);
			$iv = substr($encrypted, 0, $iv_size);
			$encrypted = substr($encrypted, $iv_size);
			$key = $encode_time.$this->key;
			$decrypted = openssl_decrypt($encrypted, $algorithm_mode, $key, $options, $iv);
			return($decrypted);
		}
		elseif(function_exists('mcrypt_decrypt'))
		{
			if($algorithm_mode === '')
				$algorithm_mode = $this->mcrypt_default_cipher;
			$last_hiphen = strrpos($algorithm_mode, '-');
			$algorithm = substr($algorithm_mode, 0, $last_hiphen);
			$mode = substr($algorithm_mode, $last_hiphen + 1);
			$iv_size = mcrypt_get_iv_size($algorithm, $mode);
			$iv = substr($encrypted, 0, $iv_size);
			$key = $this->FixKey($encode_time.$this->key);
			return mcrypt_decrypt($algorithm, $key, substr($encrypted, $iv_size), $mode, $iv);
		}
		return '';
	}

	Function Unserialize()
	{
		if(IsSet($this->cookie_value))
			return $this->cookie_value;
		if(!IsSet($_COOKIE[$this->cookie_name]))
			return null;
		if(($serialized = $this->DecodeText($_COOKIE[$this->cookie_name], $encode_time, $this->error)) === '')
			return null;
		$value = unserialize($serialized);
		if(GetType($value) != 'array')
			return null;
		return($this->cookie_value = $value);
	}

	Function Serialize($s)
	{
		if(($encrypted = $this->EncodeText(serialize($this->cookie_value = $s), 'Serialize', $this->error)) === '')
			return false;
		SetCookie($this->cookie_name, $encrypted);
		return true;
	}

	Function SetupSession(&$session)
	{
		if(!$this->GetAccessTokenURL($access_token_url))
			return false;
		if(strlen($this->session)
		|| IsSet($_COOKIE[$this->cookie_name]))
		{
			$s = $this->Unserialize();
			if(!IsSet($s))
			{
				if($this->debug)
					$this->OutputDebug('Could not decrypt the OAuth session cookie: '.$this->error);
				$session = null;
			}
			else
				$session = (IsSet($s[$access_token_url]) ? $s[$access_token_url] : null);
		}
		else
			$session = null;
		if(!IsSet($session))
		{
			$session = array(
				'state' => md5(time().rand()),
				'access_token'=>''
			);
			$session['session'] = md5($session['state'].time().rand());
			$s = array($access_token_url => $session);
			if(!$this->Serialize($s))
				return false;
		}
		$this->session = $session['session'];
		return true;
	}

	Function GetStoredState(&$state)
	{
		if(!$this->SetupSession($session))
			return false;
		$state = $session['state'];
		return true;
	}

	Function StoreAccessToken($access_token)
	{
		if(!$this->GetAccessTokenURL($access_token_url))
			return false;
		if(!$this->SetupSession($session))
			return false;
		$session['access_token'] = $access_token['value'];
		$session['access_token_secret'] = (IsSet($access_token['secret']) ? $access_token['secret'] : '');
		$session['authorized'] = (IsSet($access_token['authorized']) ? $access_token['authorized'] : null);
		$session['expiry'] = (IsSet($access_token['expiry']) ? $access_token['expiry'] : null);
		if(IsSet($access_token['type']))
			$session['type'] = $access_token['type'];
		$session['refresh_token'] = (IsSet($access_token['refresh']) ? $access_token['refresh'] : '');
		$session['access_token_response'] = (IsSet($access_token['response']) ? $access_token['response'] : null);
		$s = $this->unserialize();
		if(!IsSet($s))
			return $this->SetError('could not decrypt the OAuth session cookie');
		$s[$access_token_url] = $session;
		$this->Serialize($s);
		return true;
	}

	Function GetAccessToken(&$access_token)
	{
		if(!$this->SetupSession($session))
			return false;
		if(strlen($session['access_token']))
		{
			$access_token = array(
				'value'=>$session['access_token'],
				'secret'=>$session['access_token_secret']
			);
			if(IsSet($session['authorized']))
				$access_token['authorized'] = $session['authorized'];
			if(IsSet($session['expiry']))
				$access_token['expiry'] = $session['expiry'];
			if(strlen($session['type']))
				$access_token['type'] = $session['type'];
			if(strlen($session['refresh_token']))
				$access_token['refresh'] = $session['refresh_token'];
			if(IsSet($session['access_token_response']))
				$access_token['response'] = $session['access_token_response'];
		}
		else
			$access_token = array();
		return true;
	}

	Function ResetAccessToken()
	{
		if(!$this->GetAccessTokenURL($access_token_url))
			return false;
		if($this->debug)
			$this->OutputDebug('Resetting the access token status for OAuth server located at '.$access_token_url);
		$s = $this->unserialize();
		if(!IsSet($s))
			return $this->SetError('could not decrypt the OAuth session cookie');
		UnSet($s[$access_token_url]);
		$this->serialize($s);
		return true;
	}
};

?>