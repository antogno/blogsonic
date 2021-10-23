<?php

class LanguageSwitcherCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->tryToAcceptCookiePopup($I);
    }

    public function switchLanguage(AcceptanceTester $I)
    {
        $this->switchLanguageFromPage($I, '/', 'it', 'Welcome to Blogsonic.org', 'Benvenuto su Blogsonic.org');
        $this->switchLanguageFromPage($I, '/pages/view/home', 'it', 'Welcome to Blogsonic.org', 'Benvenuto su Blogsonic.org');

        $this->switchLanguageFromPage($I, '/it', 'en', 'Benvenuto su Blogsonic.org', 'Welcome to Blogsonic.org');
        $this->switchLanguageFromPage($I, '/it/pages/view/home', 'en', 'Benvenuto su Blogsonic.org', 'Welcome to Blogsonic.org');
    }

    private function switchLanguageFromPage(AcceptanceTester $I, string $page, string $new_language, string $before, string $after)
    {
        $I->amOnPage($page);

        $I->waitForElement('#page_body');
        $I->see($before);
        $I->selectOption('#change_language', $new_language);
        $I->waitForElement('#page_body');
        $I->see($after);
    }
}
