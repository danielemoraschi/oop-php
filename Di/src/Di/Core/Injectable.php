<?php

namespace Di\Core;

/**
 * This class allows to access services shared in the services container
 */
abstract class Injectable implements InjectionInterface
{

    /**
     * A DiInterface instance
     */
    protected $_di;

    /**
     * {@inheritdoc}
     */
    public function setDi(DiInterface $di)
    {
        $this->_di = $di;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getDi()
    {
        return $this->_di;
    }

}