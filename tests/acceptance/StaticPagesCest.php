<?php

class StaticPagesCest
{

    public function _before(AcceptanceTester $I)
    {

        $I->amOnPage('/en');

    }

    public function homePage(AcceptanceTester $I)
    {

        $I->see('Welcome to Blogsonic.org');

        $I->click('Home');
        $I->see('Welcome to Blogsonic.org');

    }

    public function aboutPage(AcceptanceTester $I)
    {

        $I->click('About');
        $I->see('Welcome to the About page of Blogsonic.org');

    }

    public function privacyPolicyPage(AcceptanceTester $I)
    {

        $I->click('Privacy policy');
        $I->see('Personal information we collect');

    }

}
