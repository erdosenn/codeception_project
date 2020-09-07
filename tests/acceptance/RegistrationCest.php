<?php

namespace acceptance;

use AcceptanceTester;
use Exception;
use Faker\Factory;
use Mapper\Errors;
use Page\AccountPage;
use Page\MainPage;
use Page\RegistrationPage;
use Page\RegistrationPage as Reg;

class RegistrationCest
{
    /**
     * @var Reg
     */
    private $registrationPage;

    /**
     * @var string
     */

    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @param MainPage $mainPage
     * @throws Exception
     */
    public function _before(MainPage $mainPage): void
    {
        $loginPage = $mainPage->goToLoginPage();
        $this->email = Factory::create()->email;
        $this->password = Factory::create()->password;
        $this->registrationPage = $loginPage->fillEmailAddressAndClickCreateAccountBtn($this->email);
    }

    // tests

    /**
     * @param AcceptanceTester $I
     * @throws Exception
     */
    public function makeCorrectRegistration(AcceptanceTester $I): void
    {
        $I->amGoingTo('Create an account');

        $this->registrationPage->fillFormAndClickRegisterBtn(true, $this->email, ['password' => $this->password]);

        $I->expect('Create account and be logged on my account');

        $I->seeInCurrentUrl(AccountPage::$URL);
        $I->see('My Account', AccountPage::PAGE_HEADING);
    }

    /**
     * @param AcceptanceTester $I
     * @throws Exception
     */
    public function makeRegistrationWithoutRequiredFields(AcceptanceTester $I): void
    {
        $I->amGoingTo('Check required fields');
        $I->click(RegistrationPage::BTN_REGISTER);

        $I->expect('Errors about missing data in required field');
        $I->waitForElement(Reg::ERROR_BOX);
        $I->see('There are 8 errors');

        $errors = [Errors::REGISTRATION_PHONE_NUMBER, Errors::REGISTRATION_FIRST_NAME, Errors::REGISTRATION_LAST_NAME];

        foreach ($errors as $error) {
            $I->see($error);
        }
    }
}
