<?php
namespace Page;

use AcceptanceTester;

class LoginPage
{
    // include url of current page
    public static $URL = '?controller=authentication&back=my-account';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    public const NAVIGATION_PAGE = '.navigation_page';
    private const CREATE_ACCOUNT = '#SubmitCreate';

    private const INPUT_REGISTRATION = '#email_create';


    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL.$param;
    }

    public function createAccount(AcceptanceTester $I, string $email): void
    {
        $I->fillField(self::INPUT_REGISTRATION, $email);
        $I->click(self::CREATE_ACCOUNT);
        $I->canSeeInCurrentUrl(RegistrationPage::$URL);
    }
}
