<?php

class ProfilesCest
{
    public $data = [
        'name' => 'Profiles',
        'surname' => 'Test',
        'gender' => 'm',
        'username' => 'profilestest',
        'password' => 'password',
        'email' => 'profiles@test.com',
        'phone' => '1234567890',
        'language' => 'en',
    ];

    public $new_data = [
        'name' => 'Incredible',
        'surname' => 'Framework',
        'password' => 'newpassword',
        'gender' => 'f'
    ];

    public function _before(AcceptanceTester $I)
    {
        $I->tryToAcceptCookiePopup($I);
    }

    public function register(AcceptanceTester $I)
    {
        $I->register($I, $this->data);
        $I->waitPageLoad($I);
        $I->see('Your account has been registered');
    }

    public function login(AcceptanceTester $I)
    {
        $I->register($I, $this->data);
        $I->login($I, ['username' => $this->data['username'], 'password' => $this->data['password']]);

        $I->waitPageLoad($I);
        $I->seeInField('name', $this->data['name']);
        $I->seeInField('surname', $this->data['surname']);
        $I->seeInField('gender', strtoupper($this->data['gender']));
        $I->seeInField('username', $this->data['username']);
        $I->seeInField('email', $this->data['email']);
        $I->seeInField('phone', $this->data['phone']);

        $I->amOnPage('en/profiles/login');

        $I->waitPageLoad($I);
        $I->see('Login');
        $I->see('You are already logged in');
    }

    public function logout(AcceptanceTester $I)
    {
        $I->register($I, $this->data);
        $I->login($I, ['username' => $this->data['username'], 'password' => $this->data['password']]);

        $I->click('#profile_dropdown');
        $I->click('Logout');

        $I->acceptPopup();

        $I->waitPageLoad($I);
        $I->see('Home');

        $I->amOnPage('/en/profiles/logout');

        $I->waitPageLoad($I);
        $I->see('Logout');
        $I->see('You have to login before you can see this page');
    }

    public function editProfile(AcceptanceTester $I)
    {
        $I->register($I, $this->data);
        $I->login($I, ['username' => $this->data['username'], 'password' => $this->data['password']]);

        $I->click('#edit');

        $I->waitPageLoad($I);
        $I->seeInField('name', $this->data['name']);
        $I->seeInField('surname', $this->data['surname']);
        $I->see('Gender');
        $I->seeInField('username', $this->data['username']);
        $I->seeInField('email', $this->data['email']);
        $I->seeInField('phone', $this->data['phone']);
        $I->see('Language');

        $I->fillField('name', $this->new_data['name']);
        $I->fillField('surname', $this->new_data['surname']);
        $I->click('#gender_' . $this->new_data['gender']);

        $I->click('#save_changes');

        $I->acceptPopup();

        $I->waitPageLoad($I);
        $I->seeInField('name', $this->new_data['name']);
        $I->seeInField('surname', $this->new_data['surname']);
    }

    public function changePassword(AcceptanceTester $I)
    {
        $I->register($I, $this->data);
        $I->login($I, ['username' => $this->data['username'], 'password' => $this->data['password']]);

        $I->click('#change_password');

        $I->fillField('old_password', 'wrongpassword');
        $I->fillField('new_password', $this->new_data['password']);

        $I->click('#save_changes');

        $I->acceptPopup();

        $I->waitPageLoad($I);
        $I->see('The Old Password is wrong');

        $I->fillField('old_password', $this->data['password']);
        $I->fillField('new_password', 'pass');

        $I->click('#save_changes');

        $I->acceptPopup();

        $I->waitPageLoad($I);
        $I->see('The New Password field must be at least 8 characters in length');

        $I->fillField('old_password', $this->data['password']);
        $I->fillField('new_password', $this->new_data['password']);

        $I->click('#save_changes');

        $I->acceptPopup();

        $I->waitPageLoad($I);
        $I->see('Your Password has been successfully updated');

        $I->logout($I);

        $I->login($I, ['username' => $this->data['username'], 'password' => $this->data['password']]);

        $I->waitPageLoad($I);
        $I->see('The Username or Password is incorrect');

        $I->login($I, ['username' => $this->data['username'], 'password' => $this->new_data['password']]);

        $I->dontSeeElement('#danger_popup');
        $I->dontSee('The Username or Password is incorrect');
    }

    public function deleteProfile(AcceptanceTester $I)
    {
        $I->register($I, $this->data);
        $I->login($I, ['username' => $this->data['username'], 'password' => $this->data['password']]);

        $I->click('#delete');

        $I->acceptPopup();

        $I->waitPageLoad($I);
        $I->see('Home');

        $I->login($I, ['username' => $this->data['username'], 'password' => $this->data['password']]);

        $I->waitPageLoad($I);
        $I->see('The Username or Password is incorrect');
    }
}