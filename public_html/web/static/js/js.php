<?php

	/**
	 * JavaScript Loader
	 *
	 * Loads all the JavaScript files in the JS directory as one big file,
	 * this means it can be loaded asynchronously without dependancies failing
	 *
	 * @category SeerUK
	 * @package  3_PHP_New-Portfolio
	 * @version  0.1-alpha
	 * @since 	 0.1-alpha
	 *
	 */

	if ( function_exists( 'date_default_timezone_set' ) )
	{
		if ( !@date_default_timezone_get() )
		{
			date_default_timezone_set( @ini_get( 'date.timezone' ) ? ini_get( 'date.timezone' ) : 'UTC' );
		}
		else
		{
			date_default_timezone_set( 'UTC' );
		}
	}

	/* Return 304 is the browser has a cached version already:
	========================================================*/
	if ( php_sapi_name() == 'apache2handler' || php_sapi_name() == 'apache' ) {
		$headers = apache_request_headers();
		if ( isset( $headers['If-Modified-Since'] ) && !empty( $headers['If-Modified-Since'] ) ) {
			header( 'HTTP/1.1 304 Not Modified' );
			exit;
		}
	}

	/* Send cache and content-type headers:
	=====================================*/
	header( 'Cache-Control: max-age=604800' );
	header( 'Content-Type: application/javascript' );
	header( 'Last-Modified: ' . date( 'F d Y H:i:s.', getlastmod() ) );


	/* Open the JS directory and list all of the minified JS files:
	=============================================================*/
	if ( $handle = opendir( './' ) ) {
		$files = array();
		while ( false !== ( $entry = readdir( $handle ) ) )
		{
			if( preg_match( '/[^\s]+(\.(?i)(min\.js))$/', $entry ) )
			{
				$files[] = $entry;
			}
		}
		closedir( $handle );
	}

	/* Always output dependancies first:
	==================================*/
	if( $key = array_search( 'jquery.min.js', $files ) )
	{
		echo file_get_contents( $files[$key] );
		echo "\n";
		unset( $files[$key] );
	}

	/* Output all other JS files:
	===========================*/
	foreach( $files as $file )
	{
		echo file_get_contents( $file );
		echo "\n";
	}