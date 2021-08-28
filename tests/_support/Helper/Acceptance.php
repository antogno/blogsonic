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
     * @return  mixed
     * @throws  \Codeception\Exception\ModuleException
     */
    public function getCurrentUrl()
    {
        return $this->getModule('WebDriver')->_getCurrentUri();
    }

    /**
     * Register a new Profile
     * 
     * @param   AcceptanceTester $I
     * @param   array $data the user data in an array with the fields as keys.
     * @return  void
     */
    public function register(AcceptanceTester $I, array $data)
    {

        $I->amOnPage('/en');

        $I->click('Profile');
        $I->click('Register');

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

        $I->click('#register');

    }

    /**
     * Login to the Profile with the given credentials
     * 
     * @param   AcceptanceTester $I
     * @param   array $credentials the user credentials in an array with the fields as keys.
     * @return  void
     */
    public function login(AcceptanceTester $I, array $credentials)
    {

        $I->amOnPage('/en');

        $I->click('Profile');
        $I->click('Login');

        $I->see('Username');
        $I->see('Password');

        $I->fillField('username', $credentials['username']);
        $I->fillField('password', $credentials['password']);

        $I->click('#login');

    }

    /**
     * Logs out from the current logged-in Profile
     * 
     * @param   AcceptanceTester $I
     * @return  void
     */
    public function logout(AcceptanceTester $I)
    {

        $I->amOnPage('/en');

        $I->click('Profile');
        $I->click('Logout');

        $I->acceptPopup();

    }

    /**
     * Deletes the Profile with the given credentials. If no credentials are given, it tries to delete the supposedly already logged-in user.
     * 
     * @param   AcceptanceTester $I
     * @param   array $credentials the user credentials in an array with the fields as keys.
     * @return  void
     */
    public function deleteProfile(AcceptanceTester $I, array $credentials)
    {

        if ( ! empty($credentials)) {
            $this->login($I, $credentials);
        }

        $I->amOnPage('/en');

        $I->click('Profile');
        $I->click('My Profile');

        $I->click('#delete');

        $I->acceptPopup();

    }

}
