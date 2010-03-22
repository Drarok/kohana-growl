# Growl Module for Kohana #

This module is a Kohana-style wrapper around the reference implementation
of Growl.

To use:

1. Clone this repository into your Kohana modules path.
2. Add the module to $application_path/config/config.php.
3. (Optional) Copy the growl.php file from the repo into $application_path/config.
4. (Optional) Edit your copy of growl.php to your liking
5. Add a call to growl::register() somewhere (I do it in my root controller
   class's constructor).
6. Sprinkle calls to growl::notify($notification_name, $title, $description)
   around your source files to help you debug.

Please feel free to contribute any changes you'd like, or suggest things.

 - Drarok
