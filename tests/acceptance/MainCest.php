<?php

use Page\MainPage;

class MainCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function checkElementsOnMainPage(AcceptanceTester $I, $loginPage)
    {
        $I->amOnPage(MainPage::$URL);
        $I->waitForElementVisible(MainPage::)
    }
}
