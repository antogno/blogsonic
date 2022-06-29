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
        $I->waitPageLoad($I);
        $I->see('Welcome to Blogsonic');

        $I->click('Home');
        $I->waitPageLoad($I);
        $I->see('Welcome to Blogsonic');
    }

    public function aboutPage(AcceptanceTester $I)
    {
        $I->click('About');
        $I->waitPageLoad($I);
        $I->see('Welcome to the About page of Blogsonic');
    }

    public function privacyPolicyPage(AcceptanceTester $I)
    {
        $I->waitPageLoad($I);
        $I->click('#privacy_policy_link');
        $I->waitPageLoad($I);
        $I->see('This Privacy policy describes how your personal information is collected');
    }
}