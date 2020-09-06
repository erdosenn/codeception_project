<?php

namespace Page;

use AcceptanceTester;

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
    public const MENU = '.sf-menu';
    public const SIGN_IN = '.login';
    public const CONTACT = '#contact-link';
    public const SLIDER = '#homepage-slider';

    public const INPUT_SEARCH = '#search_query_top';
    public const INPUT_NEWSLETTER = '#newsletter-input';

    public const BUTTON_SEARCH = '[name => submit_search]';
    public const BUTTON_NEWSLETTER = '[name => submitNewsletter]';

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     * @param mixed $param
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
     * thisIsMainPage
     *
     * @return void
     */
    public function thisIsMainPage(): void
    {
        $this->tester->waitForElementPresent(self::SLIDER);
        $this->tester->seeCurrentUrlEquals(self::$URL);
    }

    /**
     * goToLoginPage
     *
     * @return LoginPage
     */
    public function goToLoginPage(): LoginPage
    {
        $this->tester->performOn(
            self::SIGN_IN,
            function (AcceptanceTester $I) {
                $I->canSeeInCurrentUrl(LoginPage::$URL);
            }
        );
        return new LoginPage($this->tester);
    }

    /**
     * goToContactPage
     *
     * @return RegistrationPage
     */
    public function goToContactPage(): RegistrationPage
    {
        $this->tester->performOn(
            self::CONTACT,
            function () {
                $this->tester->canSeeInCurrentUrl(RegistrationPage::$URL);
            }
        );
        return new RegistrationPage($this->tester);
    }

    /**
     * searchFor
     *
     * @param mixed $phrase
     * @return void
     */
    public function searchFor(string $phrase): void
    {
        $this->tester->click(self::INPUT_SEARCH);
        $this->tester->fillField(self::INPUT_SEARCH, $phrase);
        $this->tester->click(self::BUTTON_SEARCH);
    }
}
