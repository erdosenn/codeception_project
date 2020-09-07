<?php
namespace Mapper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Codeception\Module;

class Errors extends Module
{
    public const REGISTRATION_PHONE_NUMBER = 'You must register at least one phone number.';
    public const REGISTRATION_LAST_NAME = 'lastname is required.';
    public const REGISTRATION_FIRST_NAME = 'firstname is required.';
}
