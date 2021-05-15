<?php
/*
 * login_with_polar.php
 *
 * @(#) $Id: login_with_polar.php,v 1.1 2021/01/13 22:43:51 mlemos Exp $
 *
 */

	/*
	 *  Get the http.php file from http://www.phpclasses.org/httpclient
	 */
	require('http.php');
	require('oauth_client.php');

	$client = new oauth_client_class;
	$client->server = 'Polar';

	$client->redirect_uri = 'https://'.$_SERVER['HTTP_HOST'].
		dirname(strtok($_SERVER['REQUEST_URI'],'?')).'/login_with_polar.php';

	$client->client_id = ''; $application_line = __LINE__;
	$client->client_secret = '';

	$client->debug = true;
	$client->debug_http = true;
	$client->redirect_uri = 'https://'.$_SERVER['HTTP_HOST'].
		dirname(strtok($_SERVER['REQUEST_URI'],'?')).'/login_with_polar.php';

	if(strlen($client->client_id) == 0
	|| strlen($client->client_secret) == 0)
		die('Please go to Polar Access Link APIs page '.
			'https://admin.polaraccesslink.com/#/clients '.
			'and create a new client, note down the client id and '.
			'client secret, '.$application_line. ' set the client_id '.
			'to Client ID and client_secret with Client Secret. '.
			'Make sure the domain of the URL ('.$client->redirect_uri. 
			') in the class redirect_uri variable is publicly available.');

	/* API permissions
	 */
	$client->scope = 'accesslink.read_all';
	if(($success = $client->Initialize()))
	{
		if(($success = $client->Process()))
		{
			if(strlen($client->authorization_error))
			{
				$client->error = $client->authorization_error;
				$success = false;
			}
			elseif(strlen($client->access_token))
			{
			$user_id = $client->access_token_response['x_user_id'];

			$success = $client->CallAPI(
				"https://www.polaraccesslink.com/v3/users/{$user_id}",
				"GET",
				array(),
				array(
					"FailOnAccessError" => true,
					"RequestHeaders" => array(
						"Accept" => "application/json"
					)
				),
				$user
			);
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
<title>Google OAuth client results</title>
</head>
<body>
<?php
		$first_name = 'first-name';
		echo '<h1>', HtmlSpecialChars($user->$first_name),
			' you have logged in successfully with Polar!</h1>';
		echo '<pre>', HtmlSpecialChars(print_r($user, 1)), '</pre>';
?>
</body>
</html>
<?php
	}
	else
	{
		$client->ResetAccessToken();
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