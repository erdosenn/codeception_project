<?php

namespace Page;

use AcceptanceTester;
use Page\LoginPage;

class MainPage
{
    // include url of current page
    public static $URL = 'http://automationpractice.com/index.php';
    
    /**
     * @var AcceptanceTester 
     */
    protected $tester;

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    public const HEADER_LOGO = '#header_logo';
    public const SIGN_IN = '.login';
    public const CONTACT = '#contact-link';

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     */
    public static function route($param)
    {
        return static::$URL . $param;
    }

    //wstrzyknięcie Acceptance Testera do naszej klasy
    public function __construct(AcceptanceTester $I)
    {
       $this->tester = $I;
    }

    /**
     * 
     */
    public function goToLoginPage(): void
    {        
        $I->performOn(self::SIGN_IN, function (AcceptanceTester $I) {
            $I->canSeeInCurrentUrl(LoginPage::$URL);
        });
    }

    public function goToContactPage(): void
    {
        $I->performOn(self::CONTACT, function (AcceptanceTester $I) {
            $I->canSeeInCurrentUrl(RegistrationPage::$URL);
        });
    }
}
