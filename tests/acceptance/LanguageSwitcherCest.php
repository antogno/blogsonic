<?php

class LanguageSwitcherCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->tryToAcceptCookiePopup($I);
    }

    public function switchLanguage(AcceptanceTester $I)
    {
        $this->switchLanguageFromPage($I, '/', 'it', 'Welcome to Blogsonic', 'Benvenuto su Blogsonic');
        $this->switchLanguageFromPage($I, '/pages/view/home', 'it', 'Welcome to Blogsonic', 'Benvenuto su Blogsonic');

        $this->switchLanguageFromPage($I, '/it', 'en', 'Benvenuto su Blogsonic', 'Welcome to Blogsonic');
        $this->switchLanguageFromPage($I, '/it/pages/view/home', 'en', 'Benvenuto su Blogsonic', 'Welcome to Blogsonic');
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