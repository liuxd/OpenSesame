<?php
/**
 * Framework entrance.
 */

namespace core;

require 'core/Bootstrap.php';
require 'core/Dispatcher.php';

PHP_SAPI === 'cli' ? dispatch_cli($argv) : dispatch_cgi();

# end of this file
