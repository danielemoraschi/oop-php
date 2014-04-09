<?php

namespace Core;

/**
 * A base class for all objects to inherit from.
 * 
 * See {@link \Core\Extension} on how to implement a custom multiple
 * inheritance for object instances based on PHP5 method call overloading.
 * 
 * @package core
 * @author dmoraschi
 */
abstract class Object 
{
    /**
     * Extensions are instanciated together with the object 
     * and stored in {@link $extensionInstances}.
	 *
	 * @var array $extensions
	 */
    protected static $extensions = array();
    
    /**
     * @var array $extensionsMethods
     */
    protected static $extensionsMethods = array();
    
    /**
	 * @var string the class name
	 */
	public $class;
	
	/**
	 * @var array all current extension instances.
	 */
	protected $extensionInstances = array();
    
    /**
     * 
     */
    public function __construct() 
    {
		$this->class = get_class($this);

        if (static::$extensions) {
            foreach (static::$extensions as $extension) {
                $instance = new $extension();
                $instance->setOwner($this, $this->class);
                $this->extensionInstances[$extension] = $instance;
            }
        }        
        
        $this->decorateWithMethods();
	}
    
    /**
	 * Attemps to locate and call a method dynamically 
     * added to a class at runtime if a default cannot be located
	 *
	 * You can add extra methods to a class using 
     * {@link \Core\Extensions}, {@link \Core\Object::createMethod()} or
	 * {@link \Core\Object::addWrapperMethod()}
     * 
     * @param string $method
     * @param array $arguments
     * @return mixed
     * @throws \Exception
     */
    public function __call($method, $arguments)
    {
        if (isset(self::$extensionsMethods[$this->class][$method])) {
			$config = self::$extensionsMethods[$this->class][$method];
            
            $this->extensionInstances[$config['index']]->setOwner($this);
            return call_user_func_array(
                    array($this->extensionInstances[$config['index']], $method),
                    $arguments);
            
        } else {
			throw new \Exception("Object->__call(): the method '$method' "
                    . "does not exist on '$this->class'", 2175);
		}
    }
    
    /**
	 * Adds any methods from {@link \Core\Extension} instances attached 
     * to this object.
	 * All these methods can then be called directly on the instance 
     * (transparently mapped through {@link __call()}), or called explicitly 
     * through {@link extend()}.
	 * 
	 * @uses __construct()
	 */
	protected function decorateWithMethods() {
		if (!$this->extensionInstances) {
            return;
        }
        
        foreach ($this->extensionInstances as $k => $inst) {
            $map = array_fill_keys(
                    get_class_methods($inst), array('index' => $k));

            if (self::$extensionsMethods[$this->class]) {
                self::$extensionsMethods[$this->class] = 
                        array_merge(self::$extensionsMethods[$this->class], $map);
            } else {
                self::$extensionsMethods[$this->class] = $map;
            }
        }
	}
    
    /**
	 * Add an extension to a specific class.
	 * As an alternative, extensions can be added to a specific class
	 * directly in the {@link \Core\Object::$extensions} array.
	 *
	 * @param string $class Class that should be decorated 
     * has to be a subclass of {@link \Core\Object}
	 * @param string $extension Subclass of {@link \Core\Extension}
	 */
	public static function addExtension($class, $extension) {
		if(!preg_match('/^([^(]*)/', $extension, $matches)) {
			return false;
		}
        
		$extensionClass = $matches[1];
		if (!class_exists($extensionClass)) {
			user_error(sprintf(
                    'Object::addExtension() - '
                    . 'Can\'t find extension class for "%s"', 
                    $extensionClass), 
                E_USER_ERROR);
            return false;
		}
		
		if (!is_subclass_of($extensionClass, '\Core\Extension')) {
			user_error(sprintf(
                    'Object::addExtension() - '
                    . 'Extension "%s" is not a subclass of Extension', 
                    $extensionClass), 
                E_USER_ERROR);
            return false;
		}
        
        // register the extension
        static::$extensions[] = $extension;
        return true;
	}
    
    /**
     * Run the given function on all of this object's extensions.
     * The extension methods are defined during 
     * {@link __construct()} in {@link decorateWithMethods()}.
     * 
     * @param string $method the name of the method to call on each extension
     * @param mixed $a1,... up to 7 arguments to be passed to the method
     * @return mixed
     */
    protected function extend($method, &$a1=null, &$a2=null, &$a3=null, 
            &$a4=null, &$a5=null, &$a6=null, &$a7=null)
    {
        $values = array();
        
        if ($this->extensionInstances) {
            foreach ($this->extensionInstances as $inst) {
                if(method_exists($inst, $method)) {
                    $value = $inst->$method($a1, $a2, $a3, $a4, $a5, $a6, $a7);
                    if($value !== null) {
                        $values[] = $value;
                    }
                }
            }
        }
        
        return $values;
    }
}