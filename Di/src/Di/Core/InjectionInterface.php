<?php

namespace Di\Core;

interface InjectionInterface
{
    
    /**
     * Sets the dependency injector container
     * 
     * @var \Di\Core\DiInterface
     */
    public function setDi(DiInterface $dependencyInjector);

    /**
     * Returns the dependency injector
     * 
     * @return DiInterface
     */
    public function getDi();
    
}
