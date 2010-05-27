<?php

class Growl_Hook {
	public static function log() {
		$timestamp = array_key_exists(0, Event::$data) ? Event::$data[0] : NULL;
		$log_level = array_key_exists(1, Event::$data) ? Event::$data[1] : NULL;
		$message   = array_key_exists(2, Event::$data) ? Event::$data[2] : NULL;

		growl::notify($log_level, $timestamp, $message);
	}
}

Event::add('system.log', array('Growl_Hook', 'log'));
