<?php
/**
 * Framework entrance.
 */

namespace core;

require 'core/Bootstrap.php';
require 'core/Dispatcher.php';

PHP_SAPI === 'cli' ? Dispatcher::handleCLI($argv) : Dispatcher::handleCGI();

# end of this file
