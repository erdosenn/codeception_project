<?php

namespace Page;

use AcceptanceTester;
use Exception;

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

    public const FORM_CREATE_ACCOUNT = '#create-account_form';
    public const FORM_LOGIN = '#login_form';

    public const INPUT_REGISTRATION = '#email_create';
    public const INPUT_LOGIN = '#email';
    public const INPUT_PASSWORD = '#passwd';

    public const BTN_CREATE_ACCOUNT = '#SubmitCreate';
    public const BTN_SIGN_IN = '#SubmitLogin';

    public const ERROR_BOX = '.alert-danger';

    /**
     * @var AcceptanceTester|mixed
     */
    private $tester;

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     * @param $param
     * @return string
     */
    public static function route($param)
    {
        return static::$URL . $param;
    }

    /**
     * __construct
     *
     * @param mixed $I
     * @return void
     */
    public function __construct(AcceptanceTester $I)
    {
        $this->tester = $I;
    }

    /**
     * thisIsLoginPage
     *
     * @return void
     * @throws Exception
     */
    public function thisIsLoginPage(): void
    {
        $this->tester->waitForElement(self::FORM_CREATE_ACCOUNT);
        $this->tester->seeCurrentUrlEquals(self::$URL);
    }

    /**
     * goToCreateAccount
     *
     * @param mixed $email
     * @return RegistrationPage
     * @throws Exception
     */
    public function fillEmailAddressAndClickCreateAccountBtn(string $email): RegistrationPage
    {
        $this->tester->waitForElement(self::INPUT_REGISTRATION);
        $this->tester->fillField(self::INPUT_REGISTRATION, $email);
        $this->tester->click(self::FORM_CREATE_ACCOUNT); //to check email

        $this->tester->click(self::BTN_CREATE_ACCOUNT);
        $this->tester->waitForElement(RegistrationPage::FORM);

        return new RegistrationPage($this->tester);
    }

    /**
     * @param array $credentials
     * @return void
     * @throws Exception
     */
    public function fillEmailAndPasswordAndClickSignInBtn(array $credentials): void
    {
        $this->tester->waitForElement(self::INPUT_LOGIN);
        $this->tester->fillField(self::INPUT_LOGIN, $credentials['email']);
        $this->tester->fillField(self::INPUT_PASSWORD, $credentials['password']);

        $this->tester->click(self::BTN_SIGN_IN);
    }

    /**
     * @param array $credentials
     * @return AccountPage
     * @throws Exception
     */
    public function makeCorrectLogin(array $credentials): AccountPage
    {
        $this->fillEmailAndPasswordAndClickSignInBtn($credentials);
        $this->tester->waitForElement(AccountPage::LIST_HISTORY);

        return new AccountPage($this->tester);
    }

    /**
     * @param array $credentials
     * @throws Exception
     */
    public function makeIncorrectLogin(array $credentials): void
    {
        $this->fillEmailAndPasswordAndClickSignInBtn($credentials);
        $this->tester->waitForElement(LoginPage::ERROR_BOX);
    }
}
