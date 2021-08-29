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

    public function register(AcceptanceTester $I)
    {

        $I->register($I, $this->data);
        $I->waitForElement('#success_popup');
        $I->see('Your account has been registered');

        $I->login($I, ['username' => $this->data['username'], 'password' => $this->data['password']]);
        $I->deleteProfile($I);

    }

    public function login(AcceptanceTester $I)
    {

        $I->register($I, $this->data);
        $I->login($I, ['username' => $this->data['username'], 'password' => $this->data['password']]);

        $I->waitForElement('#page_body');
        $I->seeInField('name', $this->data['name']);
        $I->seeInField('surname', $this->data['surname']);
        $I->seeInField('gender', strtoupper($this->data['gender']));
        $I->seeInField('username', $this->data['username']);
        $I->seeInField('email', $this->data['email']);
        $I->seeInField('phone', $this->data['phone']);

        $I->amOnPage('en/profiles/login');

        $I->waitForElement('#page_body');
        $I->see('Login');
        $I->see('You are already logged in');

        $I->deleteProfile($I);

    }

    public function logout(AcceptanceTester $I)
    {

        $I->register($I, $this->data);
        $I->login($I, ['username' => $this->data['username'], 'password' => $this->data['password']]);

        $I->click('Profile');
        $I->click('Logout');

        $I->acceptPopup();

        $I->waitForElement('#page_body');
        $I->see('Home');

        $I->amOnPage('/en/profiles/logout');

        $I->waitForElement('#page_body');
        $I->see('Logout');
        $I->see('You have to login before you can see this page');

        $I->deleteProfile($I, ['username' => $this->data['username'], 'password' => $this->data['password']]);

    }

    // public function forgotPassword(AcceptanceTester $I)
    // {

    //     $I->amOnPage('/');

    //     $I->click('Profile');
    //     $I->click('Login');

    //     $I->click('Forgot password?');

    //     $I->waitForElement('#page_body');
    //     $I->see('Forgot password');
    //     $I->see('Enter your Email');

    //     $I->fillField('email', 'random@email.com');

    //     $I->click('#confirm');

    //     $I->waitForElement('#danger_popup');
    //     $I->see('There are no accounts with this Email');

    //     $I->register($I, $this->data);

    //     $I->click('Profile');
    //     $I->click('Login');

    //     $I->click('Forgot password?');

    //     $I->waitForElement('#page_body');

    //     $I->fillField('email', $this->data['email']);

    //     $I->click('#confirm');

    //     $I->waitForElement('#success_popup');
    //     $I->see('We have sent a new Password to the Email address you entered');

    //     $I->login($I, ['username' => $this->data['username'], 'password' => $this->data['password']]);

    //     $I->waitForElement('#danger_popup');
    //     $I->see('The Username or Password is incorrect');

    // }

    public function editProfile(AcceptanceTester $I)
    {

        $I->register($I, $this->data);
        $I->login($I, ['username' => $this->data['username'], 'password' => $this->data['password']]);

        $I->click('#edit');

        $I->waitForElement('#page_body');
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

        $I->waitForElement('#page_body');
        $I->seeInField('name', $this->new_data['name']);
        $I->seeInField('surname', $this->new_data['surname']);

        $I->deleteProfile($I);

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

        $I->waitForElement('#danger_popup');
        $I->see('The Old Password is wrong');

        $I->fillField('old_password', $this->data['password']);
        $I->fillField('new_password', 'pass');

        $I->click('#save_changes');

        $I->acceptPopup();

        $I->waitForElement('#warning_popup');
        $I->see('The New Password field must be at least 8 characters in length');

        $I->fillField('old_password', $this->data['password']);
        $I->fillField('new_password', $this->new_data['password']);

        $I->click('#save_changes');

        $I->acceptPopup();

        $I->waitForElement('#success_popup');
        $I->see('Your Password has been successfully updated');

        $I->logout($I);

        $I->login($I, ['username' => $this->data['username'], 'password' => $this->data['password']]);

        $I->waitForElement('#danger_popup');
        $I->see('The Username or Password is incorrect');

        $I->login($I, ['username' => $this->data['username'], 'password' => $this->new_data['password']]);

        $I->dontSeeElement('#danger_popup');
        $I->dontSee('The Username or Password is incorrect');

        $I->deleteProfile($I);

    }

    public function deleteProfile(AcceptanceTester $I)
    {

        $I->register($I, $this->data);
        $I->login($I, ['username' => $this->data['username'], 'password' => $this->data['password']]);

        $I->click('#delete');

        $I->acceptPopup();

        $I->waitForElement('#page_body');
        $I->see('Home');

        $I->login($I, ['username' => $this->data['username'], 'password' => $this->data['password']]);

        $I->waitForElement('#danger_popup');
        $I->see('The Username or Password is incorrect');

    }

}
