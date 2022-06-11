<?php
/*
 * login_with_quire.php
 *
 * @(#) $Id: call_quire.php,v 1.2 2021/12/18 07:42:38 mlemos Exp $
 *
 */

	/*
	 *  Get the http.php file from http://www.phpclasses.org/httpclient
	 */
	require('http.php');
	require('oauth_client.php');
	require('file_oauth_client.php');

	$client = new file_oauth_client_class;

	/*
	 * Define options specific to your token file storage 
	 */
	$client->file = array(
		'name'=>'quire_io_token.json',
	);

	$client->debug = false;
	$client->debug_http = false;
	$client->server = 'Quire';

	$client->client_id = ''; $application_line = __LINE__;
	$client->client_secret = '';
	$client->redirect_uri = ''; $redirect_uri_line = __LINE__;

	if(strlen($client->client_id) == 0
	|| strlen($client->client_secret) == 0)
		die('Please go to Quire Apps page https://quire.io/apps/dev '.
			'create an application, and in the line '.$application_line.
			' set the client_id to App ID/API Key and client_secret with App Secret.'."\n");

	if(strlen($client->redirect_uri) == 0)
		die('Please go to Quire Apps page https://quire.io/apps/dev , '.
			'click on the application that you created, '.
			'and copy Redirect URL that you set in the Settings page to'.
			' the line '.$redirect_uri_line." .\n");

	/* API permissions
	 */
	$client->scope = '';
	if(($success = $client->Initialize()))
	{
		if(($success = $client->Process()))
		{
			if(strlen($client->access_token))
			{
				$success = $client->CallAPI(
					'https://quire.io/api/user/id/me', 
					'GET', array(), array('FailOnAccessError'=>true), $user);
			}
		}
		$success = $client->Finalize($success);
	}
	if($client->exit)
	{
		echo 'You need to initialize the Quire access token by accessing the login_with_quire.php script from the Web page!', "\n";
		exit;
	}
	if($success)
	{
		echo 'Quire.io OAuth client results', "\n";
		echo $user->name.' you have successfully accessed the Quire.io API!', "\n";
		echo print_r($user, 1);
	}
	else
	{
		echo 'OAuth client error', "\n";
		echo 'Error: ', $client->error, "\n";
	}

?>