<?php

// Automatically include the Growl reference classes.
require_once(Kohana::find_file('vendor', 'Growl', TRUE));

abstract class growl_Core {
	// Cache the connections.
	protected static $sockets = array();

	public static function register($host_alias = 'default') {
		$p = new GrowlRegistrationPacket(
			Kohana::config('growl.app_name'),
			Kohana::config('growl.hosts.'.$host_alias.'.password')
		);

		foreach (Kohana::config('growl.notifications') as $name => $enabled) {
			$p->addNotification($name, $enabled);
		}

		growl::send($host_alias, $p->payload());
	}

	public static function notify($name, $title, $description, $host_alias = 'default') {
		$p = new GrowlNotificationPacket(
			Kohana::config('growl.app_name'),
			$name, $title, $description, -2, TRUE,
			Kohana::config('growl.hosts.'.$host_alias.'.password')
		);

		growl::send($host_alias, $p->payload());
	}

	protected static function send($host_alias, $payload) {
		// If the socket isn't cached, create it.
		if (! array_key_exists($host_alias, growl::$sockets)) {
			growl::$sockets[$host_alias] = $s = socket_create(
				AF_INET,
				SOCK_DGRAM,
				SOL_UDP
			);

			// Allow broadcast packets.
			socket_set_option($s, SOL_SOCKET, SO_BROADCAST, 1);
		}

		socket_sendto(
			growl::$sockets[$host_alias],
			$payload, strlen($payload),
			0,
			Kohana::config('growl.hosts.'.$host_alias.'.host'),
			GROWL_UDP_PORT
		);
	}
}
