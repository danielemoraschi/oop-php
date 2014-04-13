<?php

namespace App\Util;

/**
 * LoggerInterface
 *
 * @author dmoraschi
 */
interface LoggerInterface
{
    
    /**
     * 
     */
    public function log($message, $level = 0, $destination = null);
    
}