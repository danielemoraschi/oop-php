<?php

namespace App\Util;

/**
 * Default logger to STDOUT
 */
class Logger extends \Di\Core\Injectable implements LoggerInterface
{
    
    /**
     * 
     * @param type $message
     * @param type $level
     * @param type $destination
     */
    public function log($message, $level = 0, $destination = null)
    {
        return fwrite(STDOUT, $message . "\n");
    }

}