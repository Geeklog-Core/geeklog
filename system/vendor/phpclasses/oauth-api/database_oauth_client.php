<?php
/*
 * database_oauth_client.php
 *
 * @(#) $Id: database_oauth_client.php,v 1.9 2015/10/16 20:05:49 mlemos Exp $
 *
 */

class database_oauth_client_class extends oauth_client_class
{
	var $service;
	var $session = '';
	var $user = 0;
	var $session_cookie = 'oauth_session';
	var $session_path = '/';
	var $sessions = array();

	Function Query($sql, $parameters, &$results, $result_types = null)
	{
		return $this->SetError('Database Query is not implemented');
	}

	Function GetStoredState(&$state)
	{
		if(!$this->SetupSession($session))
			return false;
		$state = $session->state;
		return true;
	}

	Function CreateOAuthSession($user, &$session)
	{
		$this->InitializeOAuthSession($session);
		$parameters = array(
			's', $session->session,
			's', $session->state,
			's', $session->access_token,
			's', $session->access_token_secret,
			's', $session->expiry,
			'b', $session->authorized,
			's', $session->type,
			's', $session->server,
			'ts', $session->creation,
			's', $session->refresh_token,
			's', $session->access_token_response
		);
		if(!$this->Query('INSERT INTO oauth_session (session, state, access_token, access_token_secret, expiry, authorized, type, server, creation, refresh_token, access_token_response) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', $parameters, $results))
			return false;
		$session->id = $results['insert_id'];
		return true;
	}
	
	Function SetOAuthSession(&$oauth_session, $session)
	{
		$oauth_session = new oauth_session_value_class;
		$oauth_session->id = $session[0];
		$oauth_session->session = $session[1];
		$oauth_session->state = $session[2];
		$oauth_session->access_token = $session[3];
		$oauth_session->access_token_secret = $session[4];
		$oauth_session->expiry = $session[5];
		$oauth_session->authorized = $session[6];
		$oauth_session->type = $session[7];
		$oauth_session->server = $session[8];
		$oauth_session->creation = $session[9];
		$oauth_session->refresh_token = $session[10];
		$oauth_session->access_token_response = (IsSet($session[11]) ? json_decode($session[11]) : null);
	}

	Function GetUserSession($user, &$oauth_session)
	{
		if($this->debug)
			$this->OutputDebug('Getting the OAuth session for user '.$user);
		$parameters = array(
			'i', $user,
			's', $this->server
		);
		$result_types = array(   'i','s',     's',   's',          's',                 'ts',   'b',        's',  's',    'ts',     's',           's');
		if(!$this->Query('SELECT id, session, state, access_token, access_token_secret, expiry, authorized, type, server, creation, refresh_token, access_token_response FROM oauth_session WHERE user=? AND server=?', $parameters, $results, $result_types))
			return false;
		if(count($results['rows']) === 0)
		{
			$oauth_session = null;
			return true;
		}
		$this->SetOAuthSession($oauth_session, $results['rows'][0]);
		$this->sessions[$oauth_session->session][$this->server] = $oauth_session;
		$this->session = $oauth_session->session;
		return true;
	}

	Function GetOAuthSession($session, $server, &$oauth_session)
	{
		if(IsSet($this->sessions[$session][$server]))
		{
			$oauth_session = $this->sessions[$session][$server];
			return true;
		}
		$parameters = array(
			's', $session,
			's', $server
		);
		$result_types = array(   'i','s',     's',   's',          's',                 'ts',   'b',        's',  's',    'ts',     's',           's');
		if(!$this->Query('SELECT id, session, state, access_token, access_token_secret, expiry, authorized, type, server, creation, refresh_token, access_token_response FROM oauth_session WHERE session=? AND server=?', $parameters, $results, $result_types))
			return false;
		if(count($results['rows']) === 0)
		{
			$oauth_session = null;
			return true;
		}
		$this->SetOAuthSession($oauth_session, $results['rows'][0]);
		$this->sessions[$session][$server] = $oauth_session;
		return true;
	}
	
	Function StoreAccessToken($access_token)
	{
		if(!$this->SetupSession($session))
			return false;
		$session->access_token = $access_token['value'];
		$session->access_token_secret = (IsSet($access_token['secret']) ? $access_token['secret'] : '');
		$session->authorized = (IsSet($access_token['authorized']) ? $access_token['authorized'] : null);
		$session->expiry = (IsSet($access_token['expiry']) ? $access_token['expiry'] : null);
		if(IsSet($access_token['type']))
			$session->type = $access_token['type'];
		$session->refresh_token = (IsSet($access_token['refresh']) ? $access_token['refresh'] : '');
		$session->access_token_response = (IsSet($access_token['response']) ? $access_token['response'] : null);
		if(!$this->GetOAuthSession($session->session, $this->server, $oauth_session))
			return($this->SetError('OAuth session error: '.$this->error));
		if(!IsSet($oauth_session))
		{
			$this->error = 'the session to store the access token was not found';
			return false;
		}
		$oauth_session->access_token = $session->access_token;
		$oauth_session->access_token_secret = $session->access_token_secret;
		$oauth_session->authorized = (IsSet($session->authorized) ? $session->authorized : null);
		$oauth_session->expiry = (IsSet($session->expiry) ? $session->expiry : null);
		$oauth_session->type = (IsSet($session->type) ? $session->type : '');
		$oauth_session->refresh_token = $session->refresh_token;
		$oauth_session->access_token_response = (IsSet($session->access_token_response) ? $session->access_token_response : null);
		$parameters = array(
			's', $oauth_session->session,
			's', $oauth_session->state,
			's', $oauth_session->access_token,
			's', $oauth_session->access_token_secret,
			's', $oauth_session->expiry,
			'b', $oauth_session->authorized,
			's', $oauth_session->type,
			's', $oauth_session->server,
			'ts', $oauth_session->creation,
			's', $oauth_session->refresh_token,
			's', json_encode($oauth_session->access_token_response),
			'i', $this->user,
			'i', $oauth_session->id
		);
		return $this->Query('UPDATE oauth_session SET session=?, state=?, access_token=?, access_token_secret=?, expiry=?, authorized=?, type=?, server=?, creation=?, refresh_token=?, access_token_response=?, user=? WHERE id=?', $parameters, $results);
	}

	Function GetAccessToken(&$access_token)
	{
		if($this->user)
		{
			if(!$this->GetUserSession($this->user, $session))
				return false;
			if(!IsSet($session))
				return $this->SetError('it was not found the OAuth session for user '.$this->user);
		}
		else
		{
			if(!$this->SetupSession($session))
				return false;
		}
		if(strlen($session->access_token))
		{
			$access_token = array(
				'value'=>$session->access_token,
				'secret'=>$session->access_token_secret
			);
			if(IsSet($session->authorized))
				$access_token['authorized'] = $session->authorized;
			if(IsSet($session->expiry))
				$access_token['expiry'] = $session->expiry;
			if(strlen($session->type))
				$access_token['type'] = $session->type;
			if(strlen($session->refresh_token))
				$access_token['refresh'] = $session->refresh_token;
			if(IsSet($session->access_token_response))
				$access_token['response'] = $session->access_token_response;
		}
		else
			$access_token = array();
		return true;
	}

	Function ResetAccessToken()
	{
		if($this->debug)
			$this->OutputDebug('Resetting the access token status for OAuth server located at '.$this->access_token_url);
		SetCookie($this->session_cookie, '', 0, $this->session_path);
		return true;
	}

	Function SetUser($user)
	{
		if(strlen($this->session) === 0)
			$this->SetError('it was not yet established an OAuth session');
		$parameters = array(
			'i', $user,
			's', $this->session,
			's', $this->server,
		);
		if(!$this->Query('UPDATE oauth_session SET user=? WHERE session=? AND server=?', $parameters, $results))
			return false;
		$this->user = $user;
		return true;
	}
};

?>