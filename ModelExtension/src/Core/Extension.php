<?php

namespace ModelExtenion\Core;

/**
 * Add extension that can be added to an object
 * with {@link \Core\Object::add_extension()}.
 * Each extension instance has an "owner" instance, accessible through
 * {@link getOwner()}.
 *
 * @package core
 * @author dmoraschi
 */
abstract class Extension
{

    /**
     * The Object that owns this decorator.
     *
     * @var \Core\Object
     */
    protected $owner;

    /**
     * The base class that this extension was applied to;
     * $this->owner must be one of these
     *
     * @var \Core\Object
     */
    protected $ownerBaseClass;

    /**
     *
     * @var \Core\Object
     */
    public $class;

    /**
     *
     */
    public function __construct()
    {
        $this->class = get_class($this);
    }

    /**
     * Set the owner of this decorator.
     *
     * @param \Core\Object $owner The owner object,
     * @param string $ownerBaseClass The base class that the extension
     * is applied to; this may be the class of owner, or it may be a parent.
     */
    function setOwner($owner, $ownerBaseClass = null)
    {
        $this->owner = $owner;

        if ($ownerBaseClass) {
            $this->ownerBaseClass = $ownerBaseClass;
        } elseif (!$this->ownerBaseClass && $owner) {
            $this->ownerBaseClass = $owner->class;
        }
    }

    /**
     * Returns the owner of this decorator
     *
     * @return Object
     */
    public function getOwner()
    {
        return $this->owner;
    }

}