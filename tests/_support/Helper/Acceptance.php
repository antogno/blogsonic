<?php
namespace Helper;

use AcceptanceTester;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Acceptance extends \Codeception\Module
{
    /**
     * Get the current URL
     * 
     * @return mixed
     * @throws \Codeception\Exception\ModuleException
     */
    public function getCurrentUrl()
    {
        return $this->getModule('WebDriver')->_getCurrentUri();
    }

    /**
     * Register a new Profile
     * 
     * @param AcceptanceTester $I
     * @param array $data the user data in an array with the fields
     * as keys.
     * @return void
     */
    public function register(AcceptanceTester $I, array $data)
    {
        $I->amOnPage('/en');

        $I->click('#profile_dropdown');
        $I->click('Register');

        $I->waitPageLoad($I);
        $I->see('Name');
        $I->see('Surname');
        $I->see('Gender');
        $I->see('Username');
        $I->see('Password');
        $I->see('Email');
        $I->see('Phone');
        $I->see('Language');

        $I->fillField('name', $data['name']);
        $I->fillField('surname', $data['surname']);
        $I->click('#gender_m');
        $I->fillField('username', $data['username']);
        $I->fillField('password', $data['password']);
        $I->fillField('email', $data['email']);
        $I->fillField('phone', $data['phone']);
        $I->click('#language_en');

        $I->scrollTo('#register');
        $I->waitPageLoad($I);
        $I->click('#register');
    }

    /**
     * Login to the Profile with the given credentials
     * 
     * @param AcceptanceTester $I
     * @param array $credentials the user credentials in an array
     * with the fields as keys.
     * @return void
     */
    public function login(AcceptanceTester $I, array $credentials)
    {
        $I->amOnPage('/en');

        $I->click('#profile_dropdown');
        $I->click('Login');

        $I->waitPageLoad($I);
        $I->see('Username');
        $I->see('Password');

        $I->fillField('username', $credentials['username']);
        $I->fillField('password', $credentials['password']);

        $I->click('#login');
    }

    /**
     * Logs out from the current logged-in Profile
     * 
     * @param AcceptanceTester $I
     * @return void
     */
    public function logout(AcceptanceTester $I)
    {
        $I->amOnPage('/en');

        $I->click('#profile_dropdown');
        $I->click('Logout');

        $I->acceptPopup();
    }

    /**
     * Creates a new Blog with the given data
     * 
     * @param AcceptanceTester $I
     * @param array $data the Blog's data (title and body).
     * @param int $wait how many seconds it should wait after creating
     * the blog.
     * @return void
     */
    public function createNewBlog(AcceptanceTester $I, array $data, int $wait = 0)
    {
        $I->amOnPage('/en');

        $I->click('Blogs');
        $I->click('New Blog');

        $I->fillField('blog_title', $data['title']);
        $I->fillField('blog_body', $data['body']);

        $I->click('#post');

        $I->waitPageLoad($I);

        $I->wait($wait);
    }

    /**
     * Accepts the cookie popup
     * 
     * @param AcceptanceTester $I
     * @return void
     */
    public function acceptCookiePopup(AcceptanceTester $I)
    {
        $I->amOnPage('/en');

        $I->click('#cookiebar_hide');
    }

    /**
     * Waits for the page to be fully loaded
     * 
     * @param AcceptanceTester $I
     * @return void
     */
    public function waitPageLoad(AcceptanceTester $I, $timeout = 10)
    {
        $I->waitForJs('return document.readyState == "complete"', $timeout);
    }
}