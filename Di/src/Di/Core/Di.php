<?php

namespace Di\Core;

/**
 * Dependency injection
 */
final class Di implements DiInterface, SingletonInterface
{
    
    /**
     *
     * @var DiInterface 
     */
    protected static $instance = null;
    
    /**
     *
     * @var array 
     */
    protected $services = array();
    
    /**
     *
     * @var array 
     */
    protected $instances = array();
    
    /**
     * 
     */
    protected function __construct() {}
    
    /**
     * 
     */
    public static function instance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static;
        }
        
        return static::$instance;
    }

    /**
     * 
     * @param string $name Service name
     * @param mixed $definition
     * @throws \Exception
     */
    public function set($name, $definition)
    {
        if (!is_string($name)) {
            throw new \Exception('Service name must be a string.');
        }
        
        $this->services[$name] = $definition;
    }
    
    /**
     * 
     * @param string $name The service name
     * @param bool $newInstance Create a new instance of the service
     * @param array $arguments Arguments to pass to the service
     * @return mixed
     * @throws \Exception
     */
    public function get($name, $newInstance = false, $arguments = array())
    {
        if (!isset($this->services[$name])) {
            throw new \Exception('Service "' . $name . '" not found.');
        }

        if (!$newInstance && isset($this->instances[$name])) {
            return $this->instances[$name];
        }

        // Object definitions can be a Closure or 
        // an already resolved instance
        $this->resolve($name, $arguments);

        return $this->instances[$name];
    }
    
    /**
     * Resolve a service definition
     * 
     * @param mixed $name The service name
     * @param array $arguments
     * @uses get()
     */
    private function resolve($name, $arguments = array())
    {
        if ($this->services[$name] instanceof \Closure) {
            $this->instances[$name] = call_user_func_array(
                    $this->services[$name], $arguments);
        } else {
            $this->instances[$name] = $this->services[$name];
        }
        
        if ($this->instances[$name] instanceof InjectionInterface) {
            $this->instances[$name]->setDi($this);
        }
    }
    
    /**
     * 
     * @param string $name The service name
     * @return bool
     */
    public function has($name)
    {
        return isset($this->services[$name]);
    }
    
    /**
     * Return the registered services
     * @return array
     */
    public function getServices()
    {
        return $this->services;
    }
    
    /**
     * Reset all the services definitions
     */
    public static function reset()
    {
        static::$instance = null;
    }

    /**
     * 
     * @param type $method
     * @param type $arguments
     * @return type
     */
    public function __call($method, $arguments)
    {
        $newInstance = false;
        
        if ($arguments) {
            $newInstance = (bool) $arguments[0];
            array_shift($arguments);
        }
        
        if(substr($method, 0, 3) == 'get') {
            $method = substr($method, 3);
        }
        
        return $this->get($method, $newInstance, $arguments);
    }

    /**
     * Private to prevent cloning 
     */
    private function __clone() {}
    
}