<?php

namespace Page;

use AcceptanceTester;
use Exception;
use Faker\Factory;
use Page\RegistrationPage as Reg;

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
    public const INPUT_ADDRESS_POSTCODE = "#postcode";
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
    public function thisIsRegistrationPage(): void
    {
        $this->tester->waitForElement(self::FORM);
        $this->tester->seeCurrentUrlEquals(self::$URL);
    }

    /**
     * @param array|null $date
     * @return void
     */
    public function selectBirthDate(array $date = null): void
    {
        $faker = Factory::create();

        $this->tester->selectOption(self::SELECT_BIRTH_DAY, $date["day"] ?? $faker->dayOfMonth);
        $this->tester->selectOption(self::SELECT_BIRTH_MONTH, $date["month"] ?? $faker->month());
        $this->tester->selectOption(self::SELECT_BIRTH_YEAR, $date["year"] ?? $faker->year());
    }

    /**
     * @param array|null $personalData
     * @param bool $newsletter
     * @param bool $specialOffers
     */
    public function fillPersonalInformationForm(
        array $personalData = null,
        bool $newsletter = false,
        bool $specialOffers = false
    ): void {
        $faker = Factory::create();
        $password = $faker->password(5, 10);

        $this->tester->selectOption(Reg::RADIO_TITLE, $personalData['title'] ?? 'Mr.');

        $name = $faker->firstNameMale;
        if ($personalData['title'] == 'Mrs.') {
            $name = $faker->firstNameFemale;
        }

        $this->tester->fillField(Reg::INPUT_FIRST_NAME, $personalData['first'] ?? $name);
        $this->tester->fillField(Reg::INPUT_LAST_NAME, $personalData['last'] ?? $faker->lastName);
        $this->tester->fillField(Reg::INPUT_PASSWORD, $personalData['password'] ?? $password);

        $this->selectBirthDate($personalData['birthDate']);

        if ($newsletter) {
            $this->tester->checkOption(self::CHECKBOX_NEWSLETTER);
        }
        if ($specialOffers) {
            $this->tester->checkOption(self::CHECKBOX_SPECIAL_OFFERS);
        }
    }

    /**
     * @param array|null $data
     */
    public function fillAddressForm(array $data = null): void
    {
        $faker = Factory::create();

        $this->tester->fillField(Reg::INPUT_ADDRESS_ADDRESS_1, $data['address'] ?? $faker->address);
        $this->tester->fillField(Reg::INPUT_ADDRESS_CITY, $data['city'] ?? $faker->city);
        $this->tester->fillField(Reg::INPUT_ADDRESS_POSTCODE, $data['postcode'] ?? $faker->postcode);
        $this->tester->fillField(Reg::INPUT_ADDRESS_PHONE_MOBILE, $data['phoneMobile'] ?? $faker->phoneNumber);

        $this->tester->selectOption(Reg::SELECT_STATE, $data['state'] ?? $faker->state);
    }

    /**
     * @param array|null $data
     */
    public function fillFormAndClickRegisterBtn(array $data = null)
    {
        $this->fillPersonalInformationForm($data);
        $this->fillAddressForm($data);
        $this->tester->click(self::BTN_REGISTER);
//        $this->tester->waitForElement();
//        return new RegisterSuccessPage($this->tester);
    }
}
