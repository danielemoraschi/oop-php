<?php

require 'autoload.php';


Model\User::addExtension('\Module\User\UserExtended');

$user = new Model\User;

//var_dump($user::$dbFields);
//exit;

var_dump($user->getCrudForm());
//var_dump($user->newMethod());