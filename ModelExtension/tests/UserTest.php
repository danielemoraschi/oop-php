<?php

namespace ModelExtension\Test;

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
        $user = new \ModelExtension\Model\User;
        $user->newMethod();
    }

    public function testNewMethodExtended()
    {
        \ModelExtension\Model\User::addExtension(
                '\ModelExtension\Module\User\UserExtended');
        $user = new \ModelExtension\Model\User;

        $this->assertTrue($user->newMethod());
    }

    public function testDbFieldsNotExtended()
    {
        $this->assertEquals(\ModelExtension\Model\User::$dbFields, 
                array('FirstName' => 'TextField', 'LastName' => 'TextField')
        );
    }

    public function testDbFieldsExtended()
    {
        \ModelExtension\Model\User::addExtension(
                '\ModelExtension\Module\User\UserExtended');

        $this->assertEquals(\ModelExtension\Model\User::$dbFields, 
                array('FirstName' => 'TextField', 'LastName' => 'TextField',
                    'email' => 'EmailField')
        );
    }

    public function testCrudFormNotExtended()
    {
        $user = new \ModelExtension\Model\User;

        $this->assertEquals($user->getCrudForm(), 
                array('id' => 'IntField', 'FirstName' => 'TextField',
                    'LastName' => 'TextField')
        );
    }

    public function testCrudFormExtended()
    {
        \ModelExtension\Model\User::addExtension(
                '\ModelExtension\Module\User\UserExtended');
        $user = new \ModelExtension\Model\User;

        $this->assertEquals($user->getCrudForm(), 
                array('id' => 'IntField', 'FirstName' => 'TextField',
                    'LastName' => 'TextField', 'email' => 'EmailField',
                    'email_confirm' => 'EmailField')
        );
    }

}