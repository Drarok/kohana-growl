<?php

// Automatically include the Growl reference classes.
require_once(Kohana::find_file('vendor', 'Growl', TRUE));

abstract class growl_Core {
	// Remember where we have registered.
	protected static $registered = array();

	// Connection cache.
	protected static $sockets = array();

	protected static function register($host_alias = 'default') {
		// Do not re-register.
		if (growl::registered($host_alias)) {
			return;
		}

		// Instantiate a new registration packet with config params.
		$p = new GrowlRegistrationPacket(
			Kohana::config('growl.app_name'),
			Kohana::config('growl.hosts.'.$host_alias.'.password')
		);

		// Add the notifications to the packet.
		foreach (Kohana::config('growl.notifications') as $name => $enabled) {
			$p->addNotification($name, $enabled);
		}

		// Transmit the packet.
		growl::send($host_alias, $p->payload());

		// Log the fact that we have registered.
		growl::$registered[$host_alias] = TRUE;
	}

	protected static function registered($host_alias = 'default') {
		return array_key_exists($host_alias, growl::$registered);
	}

	public static function notify($name, $title, $description, $host_alias = 'default') {
		// Ensure we are registered first.
		growl::registered($host_alias) OR growl::register($host_alias);

		// Instantiate a new notification packet with the relevant options.
		$p = new GrowlNotificationPacket(
			Kohana::config('growl.app_name'),
			$name, $title, $description, -2, TRUE,
			Kohana::config('growl.hosts.'.$host_alias.'.password')
		);

		// Transmit the packet.
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
