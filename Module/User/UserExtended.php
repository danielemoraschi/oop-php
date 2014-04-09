<?php

namespace Module\User;

/**
 * The UserExtended extension for the User model.
 *
 * @package testcase
 * @author dmoraschi
 */
class UserExtended extends \Core\ModelDecorator
{
    /**
     * @return array
     */
    public function extraStatics() {
        return array(
            'dbFields' => array(
                'email' => 'EmailField',
            ),
        );
    }
    
    /**
     * @param array $fields
     */
    public function updateCrudForm(array &$fields) {
        return $fields['email_confirm'] = 'EmailField';
    }
    
    /**
     * @return boolean
     */
    public function newMethod()
    {
        return true;
    }
}