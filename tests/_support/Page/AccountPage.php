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

    public const LIST_HISTORY = ['title' => 'Orders'];

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


}
