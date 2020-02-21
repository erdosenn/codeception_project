<?php

use Page\MainPage;

class MainCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function checkMenuOnMainPage(AcceptanceTester $I, $loginPage)
    {
        $I->amOnPage(MainPage::$URL);
        $I->waitForElementVisible(MainPage::HEADER_LOGO);
        $I->see(MainPage::MENU);
    }
}
