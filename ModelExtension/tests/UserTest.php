<?php

/**
 * @backupStaticAttributes enabled
 */
class UserTest extends PHPUnit_Framework_TestCase
{

    /**
     * @expectedException Exception
     */
    public function testNewMethodNotExtended()
    {
        $user = new Model\User;
        $user->newMethod();
    }

    public function testNewMethodExtended()
    {
        Model\User::addExtension('\Module\User\UserExtended');
        $user = new Model\User;

        $this->assertTrue($user->newMethod());
    }

    public function testDbFieldsNotExtended()
    {
        $this->assertEquals(
                Model\User::$dbFields, 
                array('FirstName' => 'TextField', 'LastName' => 'TextField')
        );
    }

    public function testDbFieldsExtended()
    {
        Model\User::addExtension('\Module\User\UserExtended');

        $this->assertEquals(
                Model\User::$dbFields, 
                array('FirstName' => 'TextField', 'LastName' => 'TextField',
                    'email' => 'EmailField')
        );
    }

    public function testCrudFormNotExtended()
    {
        $user = new Model\User;

        $this->assertEquals(
                $user->getCrudForm(), 
                array('id' => 'IntField', 'FirstName' => 'TextField',
                    'LastName' => 'TextField')
        );
    }

    public function testCrudFormExtended()
    {
        Model\User::addExtension('\Module\User\UserExtended');
        $user = new Model\User;

        $this->assertEquals(
                $user->getCrudForm(), 
                array('id' => 'IntField', 'FirstName' => 'TextField',
                    'LastName' => 'TextField', 'email' => 'EmailField',
                    'email_confirm' => 'EmailField')
        );
    }

}