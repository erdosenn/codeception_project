<?php

namespace Page;

use AcceptanceTester;
use Exception;
use Faker\Factory;

class RegistrationPage
{
    // include url of current page
    public static $URL = '?controller=authentication&back=my-account#account-creation';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    public const FORM = '#account-creation_form';

    public const RADIO_TITLE = "#uniform-id_gender1";

    public const INPUT_FIRST_NAME = '#customer_firstname';
    public const INPUT_LAST_NAME = '#customer_lastname';
    public const INPUT_EMAIL = '#email';
    public const INPUT_PASSWORD = '#passwd';

    public const INPUT_ADDRESS_FIRST_NAME = "#firstname";
    public const INPUT_ADDRESS_LAST_NAME = "#lastname";
    public const INPUT_ADDRESS_COMPANY = "#company";
    public const INPUT_ADDRESS_ADDRESS_1 = "#address1";
    public const INPUT_ADDRESS_ADDRESS_2 = "#address2";
    public const INPUT_ADDRESS_CITY = "#city";
    public const INPUT_ADDRESS_ZIP = "#postcode";
    public const INPUT_ADDRESS_ADDITIONAL_INFO = "#other";
    public const INPUT_ADDRESS_PHONE_HOME = "#phone";
    public const INPUT_ADDRESS_PHONE_MOBILE = "#phone_mobile";
    public const INPUT_ADDRESS_ALIAS = "#alias";

    public const SELECT_BIRTH_DAY = "#days";
    public const SELECT_BIRTH_MONTH = "#months";
    public const SELECT_BIRTH_YEAR = "#years";
    public const SELECT_STATE = "#id_state";
    public const SELECT_COUNTRY = "#id_country";

    public const CHECKBOX_NEWSLETTER = "#newsletter";
    public const CHECKBOX_SPECIAL_OFFERS = "#optin";

    public const BTN_REGISTER = "#submitAccount";

    /**
     * @var AcceptanceTester|mixed
     */
    private $tester;

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
     * thisIsRegistrationPage
     *
     * @param mixed $I
     * @return void
     * @throws Exception
     */
    public function thisIsRegistrationPage(AcceptanceTester $I): void
    {
        $I->waitForElement(self::FORM);
        $I->seeCurrentUrlEquals(self::$URL);
    }

    /**
     * selectBirthData
     * @param mixed $I
     * @param mixed $date
     * @return void
     */
    public function selectBirthData(AcceptanceTester $I, $date): void
    {
        $faker = Factory::create('pl_PL');
        $I->selectOption(self::SELECT_BIRTH_DAY, $date["day"] ?? $faker->dayOfMonth);
        $I->selectOption(self::SELECT_BIRTH_MONTH, $date["month"] ?? $faker->month());
        $I->selectOption(self::SELECT_BIRTH_YEAR, $date["year"] ?? $faker->year());
    }
}
