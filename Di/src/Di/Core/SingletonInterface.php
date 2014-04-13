<?php

namespace Di\Core;

/**
 * The Singleton interface contains one function, `instance()`,
 * the will return an instance of an Object that implements this
 * interface.
 * 
 * @author dmoraschi
 */
interface SingletonInterface
{
    
    public static function instance();
}