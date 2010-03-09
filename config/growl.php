<?php

$config = array(
	// Your web app's name.
	'app_name' => 'Kohana Web Application',

	// Any hosts you want to be able to send to.
	'hosts' => array(
		// Host alias is the key.
		'default' => array(
			'host' => 'localhost',
			'password' => 'password',
		),
	),

	// Notification name => enabled_by_default.
	'notifications' => array(
		'default' => TRUE,
	),
);
