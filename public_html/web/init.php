<?php

/* Configuration:
===============*/
define('SITE_NAME',  'Elliot Wright');
define('STATIC_ROOT', '/Static/');


/* Set default timezone to prevent errors if PHP hasn't been set up properly
==========================================================================*/
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