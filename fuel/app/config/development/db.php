<?php
/**
 * The development database settings. These get merged with the global settings.
 */

return array(
	'default' => array(
		'connection'  => array(
			'dsn'        => 'mysql:host=localhost;dbname=calendar',
			'username'   => 'root',
			'password'   => 'password',
		),
		'profiling' => true,
	),
);
