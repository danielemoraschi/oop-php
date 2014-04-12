<?php

namespace ModelExtenion\Core;

/**
 * Plug-ins for additional functionality in your Models.
 *
 * Note: ModelDecorator are not actually Decorators in the GoF Design Patterns 
 * sense of the word. A better name for this class would be ModelExtension.
 * 
 * @package core
 * @author dmoraschi
 */
abstract class ModelDecorator extends Extension
{

    /**
     * Statics on a {@link \Core\Object} subclass which can be decorated onto. 
     * This list is limited for security and performance reasons.
     *
     * @var array
     */
    private static $decoratableStatics = array(
        'dbFields' => true,
    );

    /**
     * The name of the method in the extension used to return
     * the extended statics variables.
     * 
     * @var string 
     */
    protected static $extraStaticsMethod = 'extraStatics';

    /**
     * Define extra static parameters.
     */
    public function extraStatics() {}

    /**
     * This function is used to provide modifications to the crud form
     * for the Model.
     * By default, no changes are made. {@link \Core\Model->getCrudForm()}.
     * 
     * @param mixed $fields
     */
    public function updateCrudForm(array &$fields) {}

    /**
     * Load the extra static definitions for the given extension
     * class name, called by {@link \Core\Object::addExtension()}
     * 
     * @param string $class Class name of the owner class (or owner base class)
     * @param string $extension Class name of the extension class
     */
    public static function loadExtraStatics($class, $extension)
    {
        if (preg_match('/^([^(]*)/', $extension, $matches)) {
            $extensionClass = $matches[1];
        } else {
            user_error("Bad extenion '$extension' - "
                    . "can't find classname", E_USER_WARNING);
            return;
        }

        $statics = call_user_func(
                array($extensionClass, self::$extraStaticsMethod), 
                $class, $extension
        );

        if (!$statics) {
            return;
        }

        $classRef = new \ReflectionClass($class);

        foreach ($statics as $name => $newValue) {
            $values = $classRef->getStaticPropertyValue($name, array());
            // array to be merged
            if (self::$decoratableStatics[$name]) {
                $classRef->setStaticPropertyValue($name, array_merge($values, $newValue));
            }
        }
    }

}