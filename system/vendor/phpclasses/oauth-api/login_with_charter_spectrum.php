<?php
/*
 * login_with_charter_spectrum.php
 *
 * @(#) $Id: login_with_charter_spectrum.php,v 1.3 2021/09/16 01:08:27 mlemos Exp $
 *
 */

	/*
	 *  Get the http.php file from http://www.phpclasses.org/httpclient
	 */
	require('http.php');
	require('oauth_client.php');

	$client = new oauth_client_class;
	$client->debug = false;
	$client->debug_http = false;
	
	/*
	 * Set the server to 'CharterSpectrumQA' or 'CharterSpectrum'
	 * depending on whether you are in production or testing
	 * environment.
	 */
	$client->server = 'CharterSpectrumQA';

	$client->redirect_uri = 'https://'.$_SERVER['HTTP_HOST'].
		dirname(strtok($_SERVER['REQUEST_URI'],'?')).'/login_with_charter_spectrum.php';

	$client->client_id = ''; $application_line = __LINE__;
	$client->client_secret = '';

	$client->scope = 'CarrierSmallMediumBusiness_Read';

	if(strlen($client->client_id) == 0
	|| strlen($client->client_secret) == 0)
		die('Please ask Spectrum technical support people to '.
			'create an application, and in the line '.$application_line.
			' set the client_id to Client ID and client_secret Client Secret'.
			' that you get from them . ');

	if(($success = $client->Initialize()))
	{
		if(($success = $client->Process()))
		{
			if(strlen($client->access_token))
			{
				/*
				 * Check the documentation of Charter Spectrum to
				 * determine the correct URLs of the API calls depending
				 * on whether you are a testing or production environment.
				 */
/*
				$url = 'https://eli-security-uat.charter.com/core/connect/userinfo';
				$success = $client->CallAPI(
					$url,
					'GET', array(), array(
						'FailOnAccessError' => true, 
					), $user);
*/
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
<title>Spectrum OAuth client results</title>
</head>
<body>
<?php
		echo '<h1>You have logged in successfully with Charter Spectrum!</h1>';
		echo '<pre>Access token:', "\n\n", HtmlSpecialChars(print_r($client->access_token, 1)), '</pre>';
/*
		echo '<pre>User:', "\n\n", HtmlSpecialChars(print_r($user, 1)), '</pre>';
*/
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