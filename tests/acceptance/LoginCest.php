<?php

namespace acceptance;

use AcceptanceTester;
use Codeception\Example;
use Exception;
use Faker\Factory;
use Page\AccountPage;
use Page\LoginPage;
use Page\MainPage;

class LoginCest
{
    const CREDENTIALS = 'credentials';
    const EMAIL = 'email';
    const PASSWORD = 'password';
    const ERROR = 'error';
    
    /**
     * @var LoginPage
     */
    private $loginPage;

    /**
     * @return string[]
     */
    protected function credentialsProvider(): array
    {
        return [
            [
                self::CREDENTIALS => [
                    self::EMAIL => '',
                    self::PASSWORD => '',
                ],
                self::ERROR => 'An email address required.',
            ],
            [
                self::CREDENTIALS => [
                    self::EMAIL => 'invalidEmail',
                    self::PASSWORD => '',
                ],
                self::ERROR => 'Invalid email address.',
            ],
            [
                self::CREDENTIALS => [
                    self::EMAIL => 'email@email.com',
                    self::PASSWORD => '',
                ],
                self::ERROR => 'Password is required.',
            ],
            [
                self::CREDENTIALS => [
                    self::EMAIL => 'email@email.com',
                    self::PASSWORD => 'sdassd',
                ],
                self::ERROR => 'Authentication failed.',
            ],
        ];
    }

    /**
     * @param MainPage $mainPage
     * @throws Exception
     */
    public function _before(MainPage $mainPage)
    {
        $this->loginPage = $mainPage->goToLoginPage();
    }

    // tests

    /**
     * @param AcceptanceTester $I
     * @throws Exception
     */
    public function makeCorrectLogin(AcceptanceTester $I): void
    {
        $email = Factory::create()->email;
        $password = Factory::create()->password;

        $registrationPage = $this->loginPage->fillEmailAddressAndClickCreateAccountBtn($email);
        $accountPage = $registrationPage->fillFormAndClickRegisterBtn(
            true,
            $email,
            [self::PASSWORD => $password]
        );

        $loginPage = $accountPage->logoutFromAccount();

        $loginPage->makeCorrectLogin([self::EMAIL => $email, self::PASSWORD => $password]);

        $I->seeElement(AccountPage::LIST_HISTORY);
        $I->see("My Account", AccountPage::PAGE_HEADING);
    }

    /**
     * @param AcceptanceTester $I
     * @dataProvider credentialsProvider
     * @param Example $example
     * @throws Exception
     */
    public function loginWithWrongCredentials(AcceptanceTester $I, Example $example): void
    {
        $I->amGoingTo("Check errors when provide wrong credentials");

        $this->loginPage->makeIncorrectLogin($example[self::CREDENTIALS]);
        $I->waitForElement(LoginPage::ERROR_BOX);

        $I->see($example[self::ERROR]);
    }
}
