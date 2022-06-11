<?php
/*
 * login_with_quire.php
 *
 * @(#) $Id: login_with_quire.php,v 1.1 2021/12/18 07:15:56 mlemos Exp $
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

	$client->debug = true;
	$client->debug_http = true;
	$client->server = 'Quire';

	$client->redirect_uri = 'https://'.$_SERVER['HTTP_HOST'].
		dirname(strtok($_SERVER['REQUEST_URI'],'?')).'/login_with_quire.php';

	$client->client_id = ''; $application_line = __LINE__;
	$client->client_secret = '';

	if(strlen($client->client_id) == 0
	|| strlen($client->client_secret) == 0)
		die('Please go to Quire Apps page https://quire.io/apps/dev , '.
			'create an application, and in the line '.$application_line.
			' set the client_id to App ID/API Key and client_secret with App Secret');

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
		exit;
	if($success)
	{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Quire.io OAuth client results</title>
</head>
<body>
<?php
		echo '<h1>', HtmlSpecialChars($user->name), 
			' you have logged in successfully with Quire.io!</h1>';
		echo '<pre>', HtmlSpecialChars(print_r($user, 1)), '</pre>';
?>
</body>
</html>
<?php
	}
	else
	{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>OAuth client error</title>
</head>
<body>
<h1>OAuth client error</h1>
<pre>Error: <?php echo HtmlSpecialChars($client->error); ?></pre>
</body>
</html>
<?php
	}

?>