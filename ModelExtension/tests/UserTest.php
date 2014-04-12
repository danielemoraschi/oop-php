<?php

namespace ModelExtenion\Test;

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
        $user = new ModelExtenion\Model\User;
        $user->newMethod();
    }

    public function testNewMethodExtended()
    {
        ModelExtenion\Model\User::addExtension('\Module\User\UserExtended');
        $user = new ModelExtenion\Model\User;

        $this->assertTrue($user->newMethod());
    }

    public function testDbFieldsNotExtended()
    {
        $this->assertEquals(
                ModelExtenion\Model\User::$dbFields, 
                array('FirstName' => 'TextField', 'LastName' => 'TextField')
        );
    }

    public function testDbFieldsExtended()
    {
        ModelExtenion\Model\User::addExtension('\Module\User\UserExtended');

        $this->assertEquals(
                ModelExtenion\Model\User::$dbFields, 
                array('FirstName' => 'TextField', 'LastName' => 'TextField',
                    'email' => 'EmailField')
        );
    }

    public function testCrudFormNotExtended()
    {
        $user = new ModelExtenion\Model\User;

        $this->assertEquals(
                $user->getCrudForm(), 
                array('id' => 'IntField', 'FirstName' => 'TextField',
                    'LastName' => 'TextField')
        );
    }

    public function testCrudFormExtended()
    {
        ModelExtenion\Model\User::addExtension('\Module\User\UserExtended');
        $user = new ModelExtenion\Model\User;

        $this->assertEquals(
                $user->getCrudForm(), 
                array('id' => 'IntField', 'FirstName' => 'TextField',
                    'LastName' => 'TextField', 'email' => 'EmailField',
                    'email_confirm' => 'EmailField')
        );
    }

}