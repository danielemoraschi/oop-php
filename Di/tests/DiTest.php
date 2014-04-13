<?php

namespace App\Test;

/**
 *
 * @author dmoraschi
 */
class DiTest extends \PHPUnit_Framework_TestCase
{

    public function testLoggerAsService()
    {
        $di = \Di\Core\Di::instance();

        // Registering shared services

        $di->set('Logger', function() {
            return new \App\Util\Logger();
        });
        
        $string = "********TEST********";
        
        $ret = $di->getLogger()->log($string);
        $this->assertEquals(strlen($string) + 1, $ret);
        
        $ret = $di->get('Logger')->log($string);
        $this->assertEquals(strlen($string) + 1, $ret);
    }

}