<?php

namespace Di\Core;

/**
 * Description of DiInterface
 *
 * @author dmoraschi
 */
interface DiInterface
{
    
    /**
     * 
     */
    public function set($name, $definition);
    
    /**
     * 
     */
    public function get($name, $arguments = null);
    
    /**
     * 
     */
    public function has($name);
    
    /**
     * 
     */
    public function getServices();
    
    /**
     * 
     */
    public static function reset();
    
}