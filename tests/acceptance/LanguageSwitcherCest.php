<?php

class LanguageSwitcherCest
{

    // public function _before(AcceptanceTester $I)
    // {

        

    // }

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

        $I->see($before);
        $I->selectOption('#change_language', $new_language);
        $I->see($after);

    }

}
