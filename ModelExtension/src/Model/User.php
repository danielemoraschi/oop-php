<?php

namespace ModelExtension\Model;

/**
 * The base User model
 *
 * @package testcase
 * @author dmoraschi
 */
class User extends \ModelExtension\Core\Model
{

    public static $extensions = array(
            //'\Module\User\UserExtended',
    );
    
    public static $dbFields = array(
        'FirstName' => 'TextField',
        'LastName' => 'TextField'
    );

    public function getCrudForm()
    {
        $fields = parent::getCrudForm();
        return $fields;
    }

}