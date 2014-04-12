<?php

namespace App\Test;

/**
 * @backupStaticAttributes enabled
 */
class UserTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @expectedException Exception
     */
    public function testNewMethodNotExtended()
    {
        $user = new \App\Model\User;
        $user->newMethod();
    }

    public function testNewMethodExtended()
    {
        \App\Model\User::addExtension(
                '\App\Module\User\UserExtended');
        $user = new \App\Model\User;

        $this->assertTrue($user->newMethod());
    }

    public function testDbFieldsNotExtended()
    {
        $this->assertEquals(\App\Model\User::$dbFields, 
                array('FirstName' => 'TextField', 'LastName' => 'TextField')
        );
    }

    public function testDbFieldsExtended()
    {
        \App\Model\User::addExtension(
                '\App\Module\User\UserExtended');

        $this->assertEquals(\App\Model\User::$dbFields, 
                array('FirstName' => 'TextField', 'LastName' => 'TextField',
                    'email' => 'EmailField')
        );
    }

    public function testCrudFormNotExtended()
    {
        $user = new \App\Model\User;

        $this->assertEquals($user->getCrudForm(), 
                array('id' => 'IntField', 'FirstName' => 'TextField',
                    'LastName' => 'TextField')
        );
    }

    public function testCrudFormExtended()
    {
        \App\Model\User::addExtension(
                '\App\Module\User\UserExtended');
        $user = new \App\Model\User;

        $this->assertEquals($user->getCrudForm(), 
                array('id' => 'IntField', 'FirstName' => 'TextField',
                    'LastName' => 'TextField', 'email' => 'EmailField',
                    'email_confirm' => 'EmailField')
        );
    }

}