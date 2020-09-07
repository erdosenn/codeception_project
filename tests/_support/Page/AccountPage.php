<?php
namespace Page;

use AcceptanceTester;
use Exception;

class AccountPage
{
    // include url of current page
    public static $URL = '?controller=my-account';
    /**
     * @var AcceptanceTester|mixed
     */
    private $tester;
    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    public const ADDRESSES_LIST = '.row addresses-lists';

    public const PAGE_HEADING = '.page-heading';

    public const LIST_HISTORY = '//*[@title="Orders"]';

    public const BTN_ACCOUNT = '.account';
    public const BTN_SIGN_OUT = '.logout';

    /**
     * Basic route example for your current URL
     * You can append any additional parameter to URL
     * and use it in tests like: Page\Edit::route('/123-post');
     * @param $param
     * @return string
     */

    public static function route($param)
    {
        return static::$URL.$param;
    }

    /**
     * @param mixed $I
     * @return void
     */
    public function __construct(AcceptanceTester $I)
    {
        $this->tester = $I;
    }

    /**
     * @return void
     * @throws Exception
     */
    public function thisIsAccountPage(): void
    {
        $this->tester->waitForElement(self::ADDRESSES_LIST);
        $this->tester->seeInCurrentUrl(self::$URL);
    }

    /**
     * @throws Exception
     */
    public function logoutFromAccount(): LoginPage
    {
        $this->tester->click(self::BTN_SIGN_OUT);
        $this->tester->waitForElement(LoginPage::INPUT_LOGIN);
        return new LoginPage($this->tester);
    }

}
