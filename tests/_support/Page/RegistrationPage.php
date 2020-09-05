<?php
namespace Page;

use AcceptanceTester;

class RegistrationPage
{
    // include url of current page
    public static $URL = '#account-creation';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL.$param;
    }

    /**
     * __construct
     *
     * @param  mixed $I
     * @return void
     */
    public function __construct(AcceptanceTester $I)
    {
       $this->tester = $I;
    }

}
