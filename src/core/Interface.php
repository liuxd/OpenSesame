<?php
/**
 * The Interface for the application controllers.
 */

namespace core;

interface IController
{
    /**
     * The hook before handler.
     */
    public function before();

    /**
     * The main logic method.
     */
    public function handle();

    /**
     * The hook after handler.
     */
    public function after();
}

# end of this file
