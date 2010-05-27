# Growl Module for Kohana #

This module is a Kohana-style wrapper around the reference implementation
of Growl.

To use:

1. Clone this repository into your Kohana modules path.
2. Add the module to $application_path/config/config.php.
3. (Recommended) Copy growl.php from the repo into $application_path/config
   and edit it there.
4. (Optional) Enable hooks if you want all Kohana::log() messages to be
   Growled automatically.
5. Add calls to growl::notify() around your source files to help you debug.

Please feel free to contribute any changes you'd like, or suggest features.

 - Drarok
