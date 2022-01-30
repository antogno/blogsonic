<?php

class StaticPagesCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->tryToAcceptCookiePopup($I);

        $I->amOnPage('/en');
    }

    public function homePage(AcceptanceTester $I)
    {
        $I->waitForElement('#page_body');
        $I->see('Welcome to Blogsonic');

        $I->click('Home');
        $I->waitForElement('#page_body');
        $I->see('Welcome to Blogsonic');
    }

    public function aboutPage(AcceptanceTester $I)
    {
        $I->click('About');
        $I->waitForElement('#page_body');
        $I->see('Welcome to the About page of Blogsonic');
    }

    public function privacyPolicyPage(AcceptanceTester $I)
    {
        $I->waitForElement('#privacy_policy_link');
        $I->click('#privacy_policy_link');
        $I->waitForElement('#page_body');
        $I->see('This Privacy policy describes how your personal information is collected');
    }
}