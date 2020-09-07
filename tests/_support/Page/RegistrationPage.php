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

    public const RADIO_TITLE_MR = '#id_gender1';
    public const RADIO_TITLE_MRS = '#id_gender2';

    public const INPUT_FIRST_NAME = '#customer_firstname';
    public const INPUT_LAST_NAME = '#customer_lastname';
    public const INPUT_EMAIL = '#email';
    public const INPUT_PASSWORD = '#passwd';

    public const INPUT_ADDRESS_FIRST_NAME = '#firstname';
    public const INPUT_ADDRESS_LAST_NAME = '#lastname';
    public const INPUT_ADDRESS_COMPANY = '#company';
    public const INPUT_ADDRESS_ADDRESS_1 = '#address1';
    public const INPUT_ADDRESS_ADDRESS_2 = '#address2';
    public const INPUT_ADDRESS_CITY = '#city';
    public const INPUT_ADDRESS_POSTCODE = '#postcode';
    public const INPUT_ADDRESS_ADDITIONAL_INFO = '#other';
    public const INPUT_ADDRESS_PHONE_HOME = '#phone';
    public const INPUT_ADDRESS_PHONE_MOBILE = '#phone_mobile';
    public const INPUT_ADDRESS_ALIAS = '#alias';

    public const SELECT_BIRTH_DAY = '#days';
    public const SELECT_BIRTH_MONTH = '#months';
    public const SELECT_BIRTH_YEAR = '#years';
    public const SELECT_STATE = '#id_state';
    public const SELECT_COUNTRY = '#id_country';

    public const CHECKBOX_NEWSLETTER = '#newsletter';
    public const CHECKBOX_SPECIAL_OFFERS = '#optin';

    public const BTN_REGISTER = '#submitAccount';

    public const ERROR_BOX = '.alert-danger';

    /**
     * @var AcceptanceTester|mixed
     */
    private $tester;
    /**
     * @var string
     */
    public $firstName;
    /**
     * @var string
     */
    public $lastName;
    /**
     * @var string
     */
    public $password;

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
     * @param string|null $date
     * @return void
     */
    public function selectBirthDate(string $date): void
    {
        $this->tester->selectOption(self::SELECT_BIRTH_DAY, date('j', strtotime($date)));
        $this->tester->selectOption(self::SELECT_BIRTH_MONTH, date('F', strtotime($date)));
        $this->tester->selectOption(self::SELECT_BIRTH_YEAR, date('Y', strtotime($date)));
    }

    /**
     * @param bool $male
     * @param array|null $personalData
     * @param bool $newsletter
     * @param bool $specialOffers
     */
    public function fillPersonalInformationForm(
        bool $male,
        array $personalData = null,
        bool $newsletter = false,
        bool $specialOffers = false
    ): void {
        $faker = Factory::create();
        $this->password = $faker->password(6, 10);

        if ($male) {
            $this->tester->checkOption(Reg::RADIO_TITLE_MR);
            $this->firstName = $faker->firstNameMale;
        } else {
            $this->tester->checkOption(Reg::RADIO_TITLE_MRS);
            $this->firstName = $faker->firstNameFemale;
        }
        $this->lastName = $faker->lastName;

        $this->tester->fillField(Reg::INPUT_FIRST_NAME, $personalData['first'] ?? $this->firstName);
        $this->tester->fillField(Reg::INPUT_LAST_NAME, $personalData['last'] ?? $this->lastName);
        $this->tester->fillField(Reg::INPUT_PASSWORD, $personalData['password'] ?? $this->password);

        $this->selectBirthDate($personalData['birthDate'] ?? $faker->date('j-F-Y', '- 20 years'));

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

        $postcode = $faker->postcode;
        if (strpos($postcode, '-')){
            $postcode = explode('-', $postcode)[0];
        }

        $this->tester->fillField(Reg::INPUT_ADDRESS_ADDRESS_1, $data['address'] ?? $faker->streetAddress);
        $this->tester->fillField(Reg::INPUT_ADDRESS_CITY, $data['city'] ?? $faker->city);
        $this->tester->fillField(Reg::INPUT_ADDRESS_POSTCODE, $data['postcode'] ?? $postcode);
        $this->tester->fillField(Reg::INPUT_ADDRESS_PHONE_MOBILE, $data['phoneMobile'] ?? $faker->phoneNumber);

        $this->tester->selectOption(Reg::SELECT_STATE, $data['state'] ?? $faker->state);
    }

    /**
     * @param bool $male
     * @param string $email
     * @param array|null $data
     * @param bool $newsletter
     * @param bool $specialOffers
     * @return AccountPage
     * @throws Exception
     */
    public function fillFormAndClickRegisterBtn(
        bool $male,
        string $email,
        array $data = null,
        bool $newsletter = false,
        bool $specialOffers = false
    ): AccountPage {
        $this->fillPersonalInformationForm($male, $data, $newsletter, $specialOffers);
        $this->checkRecurringInputs($email);
        $this->fillAddressForm($data);

        $this->tester->click(self::BTN_REGISTER);
        $this->tester->waitForElement(AccountPage::LIST_HISTORY);
        return new AccountPage($this->tester);
    }

    /**
     * @param string $email
     */
    public function checkRecurringInputs(string $email): void
    {
        $this->tester->seeInField(self::INPUT_EMAIL, $email);
        $this->tester->seeInField(self::INPUT_ADDRESS_FIRST_NAME, $this->firstName);
        $this->tester->seeInField(self::INPUT_ADDRESS_LAST_NAME, $this->lastName);
    }
}
