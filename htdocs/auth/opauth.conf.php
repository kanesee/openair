<?php
/**
 * Opauth basic configuration file to quickly get you started
 * ==========================================================
 * To use: rename to opauth.conf.php and tweak as you like
 * If you require advanced configuration options, refer to opauth.conf.php.advanced
 */

$config = array(
/**
 * Path where Opauth is accessed.
 *  - Begins and ends with /
 *  - eg. if Opauth is reached via http://example.org/auth/, path is '/auth/'
 *  - if Opauth is reached via http://auth.example.org/, path is '/'
 */
	//'path' => '/',
	'path' => '/auth/',

/**
 * Callback URL: redirected to after authentication, successful or otherwise
 */
	'callback_url' => '{path}callback.php',
	
/**
 * A random string used for signing of $auth response.
 * 
 * NOTE: PLEASE CHANGE THIS INTO SOME OTHER RANDOM STRING
 */
	'security_salt' => 'kaneLDFmiilYf8Fyw5W10rx4W1KsVrieQCnpBzzpTBWA5vJidQKDx8pMJbmw28R1C4m',
		
/**
 * Strategy
 * Refer to individual strategy's documentation on configuration requirements.
 * 
 * eg.
 * 'Strategy' => array(
 * 
 *   'Facebook' => array(
 *      'app_id' => 'APP ID',
 *      'app_secret' => 'APP_SECRET'
 *    ),
 * 
 * )
 *
 */
	'Strategy' => array(
		// Define strategies and their respective configs here
		
		'Facebook' => array(
			'app_id' => 'YOUR APP ID',
			'app_secret' => 'YOUR APP SECRET'
		),
		
		'Google' => array(
			'client_id' => 'YOUR CLIENT ID',
			'client_secret' => 'YOUR CLIENT SECRET'
		),
		
		'Twitter' => array(
			'key' => 'qMKXwHYWKbdO1brtrqPDC9ozj',
			'secret' => 'Scv4ALgUh06Vl34wcox03JPB09Y3Z7pd6Ta56WZoHjaq880N0J'
		),
				
	),
);
