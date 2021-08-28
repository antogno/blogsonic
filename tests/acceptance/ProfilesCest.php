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
    
    // public function _before(AcceptanceTester $I)
    // {

            

    // }

    public function register(AcceptanceTester $I)
    {

        $I->register($I, $this->data);
        $I->waitForElement('#success_popup');
        $I->see('Your account has been registered');

        // $this->registerSameValues($I);
        // $this->registerNoValues($I);
        // $this->registerInvalidCredentials($I);

    }

    public function login(AcceptanceTester $I)
    {

        $I->login($I, ['username' => $this->data['username'], 'password' => $this->data['password']]);
        $I->see('Name');
        $I->see('Surname');
        $I->see('Gender');
        $I->see('Username');
        $I->see('Password');
        $I->see('Email');
        $I->see('Phone');
        $I->see('Language');

        $this->editProfile($I);
        $this->changePassword($I);
        $this->logout($I);
        $this->forgotPassword($I);
        // $this->loginNoCredentials($I);
        // $this->loginInvalidCredentials($I);
        // $this->loginWrongCredentials($I);
        $this->deleteProfile($I);

    }

    private function editProfile(AcceptanceTester $I)
    {

        $I->click('#edit');

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

        $I->seeInField('name', $this->new_data['name']);
        $I->seeInField('surname', $this->new_data['surname']);
        $I->see($this->new_data['gender']);

    }

    private function changePassword(AcceptanceTester $I)
    {

        $I->click('#change_password');

        $I->fillField('old_password', $this->data['password']);
        $I->fillField('new_password', $this->new_data['password']);

        $I->click('#save_changes');

        $I->acceptPopup();

        $I->waitForElement('#success_popup');
        $I->see('Your Password has been successfully updated');

        // $this->changePasswordNoPasswords($I);
        // $this->changePasswordSameNewPassword($I);
        // $this->changePasswordWrongOldPassword($I);
        // $this->changePasswordInvalidNewPassword($I);

    }

    private function logout(AcceptanceTester $I)
    {

        $I->click('Profile');
        $I->click('Logout');

        $I->acceptPopup();

        $I->see('Home');

        $I->amOnPage('/en/profiles/logout');

        $I->see('Logout');
        $I->see('You have to login before you can see this page');

    }

    private function forgotPassword(AcceptanceTester $I)
    {

        $I->click('Profile');
        $I->click('Login');

        $I->click('Forgot password?');

        $I->see('Forgot password');
        $I->see('Enter your Email');

    }

    private function deleteProfile(AcceptanceTester $I)
    {

        $I->login($I, ['username' => $this->data['username'], 'password' => $this->new_data['password']]);
        $I->see('Name');
        $I->see('Surname');
        $I->see('Gender');
        $I->see('Username');
        $I->see('Password');
        $I->see('Email');
        $I->see('Phone');
        $I->see('Language');

        $I->click('#delete');

        $I->acceptPopup();

        $I->see('Home');

        $I->login($I, ['username' => $this->data['username'], 'password' => $this->new_data['password']]);
        $I->waitForElement('#danger_popup');
        $I->see('The Username or Password is incorrect');

    }

    // private function registerSameValues(AcceptanceTester $I)
    // {

    //     $I->fillField('name', $this->data['name']);
    //     $I->fillField('surname', $this->data['surname']);
    //     $I->click('#gender_' . $this->data['gender']);
    //     $I->fillField('username', $this->data['username']);
    //     $I->fillField('password', $this->data['password']);
    //     $I->fillField('email', $this->data['email']);
    //     $I->fillField('phone', $this->data['phone']);
    //     $I->click('#language_' . $this->data['language']);

    //     $I->click('#register');

    //     $I->waitForElement('#warning_popup');
    //     $I->see('The Username field must contain a unique value');
    //     $I->see('The Email field must contain a unique value');
    //     $I->see('The Phone field must contain a unique value');

    // }

    // private function registerNoValues(AcceptanceTester $I)
    // {

    //     $I->click('#register');

    //     $I->waitForElement('#warning_popup');
    //     $I->see('The Name field is required');
    //     $I->see('The Surname field is required');
    //     $I->see('The Gender field is required');
    //     $I->see('The Username field is required');
    //     $I->see('The Password field is required');
    //     $I->see('The Email field is required');
    //     $I->see('The Phone field is required');
    //     $I->see('The Language field is required');

    // }

    // private function registerInvalidCredentials(AcceptanceTester $I)
    // {

    //     $I->fillField('name', $this->data['name']);
    //     $I->fillField('surname', $this->data['surname']);
    //     $I->click('#gender_' . $this->data['gender']);
    //     $I->fillField('username', $this->data['username']);
    //     $I->fillField('password', 'pass');
    //     $I->fillField('email', $this->data['email']);
    //     $I->fillField('phone', $this->data['phone']);
    //     $I->click('#language_' . $this->data['language']);

    //     $I->click('#register');

    //     $I->waitForElement('#warning_popup');
    //     $I->see('The Password field must be at least 8 characters in length');

    //     $I->fillField('name', $this->data['name']);
    //     $I->fillField('surname', $this->data['surname']);
    //     $I->click('#gender_' . $this->data['gender']);
    //     $I->fillField('username', '??????');
    //     $I->fillField('password', $this->data['password']);
    //     $I->fillField('email', $this->data['email']);
    //     $I->fillField('phone', $this->data['phone']);
    //     $I->click('#language_' . $this->data['language']);

    //     $I->click('#register');

    //     $I->waitForElement('#warning_popup');
    //     $I->see('The Username field may only contain alpha-numeric characters, underscores, and dashes');

    //     $I->fillField('name', $this->data['name']);
    //     $I->fillField('surname', $this->data['surname']);
    //     $I->click('#gender_' . $this->data['gender']);
    //     $I->fillField('username', 'user');
    //     $I->fillField('password', $this->data['password']);
    //     $I->fillField('email', $this->data['email']);
    //     $I->fillField('phone', $this->data['phone']);
    //     $I->click('#language_' . $this->data['language']);

    //     $I->click('#register');

    //     $I->waitForElement('#warning_popup');
    //     $I->see('The Username field must be at least 6 characters in length');

    // }

    // private function loginNoCredentials(AcceptanceTester $I)
    // {

    //     $I->login($I, ['username' => '', 'password' => $this->data['password']]);
    //     $I->waitForElement('#warning_popup');
    //     $I->see('The Username field is required');

    //     $I->login($I, ['username' => $this->data['username'], 'password' => '']);
    //     $I->waitForElement('#warning_popup');
    //     $I->see('The Password field is required');

    // }

    // private function loginInvalidCredentials(AcceptanceTester $I)
    // {

    //     $I->login($I, ['username' => 'user', 'password' => $this->data['password']]);
    //     $I->waitForElement('#warning_popup');
    //     $I->see('The Username field must be at least 6 characters in length');

    //     $I->login($I, ['username' => $this->data['username'], 'password' => 'pass']);
    //     $I->waitForElement('#warning_popup');
    //     $I->see('The Password field must be at least 8 characters in length');

    //     $I->login($I, ['username' => '??????', 'password' => $this->data['password']]);
    //     $I->waitForElement('#warning_popup');
    //     $I->see('The Username field may only contain alpha-numeric characters, underscores, and dashes');

    // }

    // private function loginWrongCredentials(AcceptanceTester $I)
    // {

    //     $I->login($I, ['username' => 'username', 'password' => $this->data['password']]);
    //     $I->waitForElement('#danger_popup');
    //     $I->see('The Username or Password is incorrect');

    //     $I->login($I, ['username' => $this->data['username'], 'password' => 'password']);
    //     $I->waitForElement('#danger_popup');
    //     $I->see('The Username or Password is incorrect');

    // }

    // private function changePasswordNoPasswords(AcceptanceTester $I)
    // {

    //     $I->fillField('new_password', 'newpassword');
    //     $I->click('#save_changes');
    //     $I->acceptPopup();
    //     $I->waitForElement('#warning_popup');
    //     $I->see('The Old Password field is required');

    //     $I->fillField('old_password', 'oldpassword');
    //     $I->click('#save_changes');
    //     $I->acceptPopup();
    //     $I->waitForElement('#warning_popup');
    //     $I->see('The New Password field is required');

    // }

    // private function changePasswordSameNewPassword(AcceptanceTester $I)
    // {

    //     $I->fillField('old_password', $this->new_data['password']);
    //     $I->fillField('new_password', $this->new_data['password']);

    //     $I->click('#save_changes');

    //     $I->acceptPopup();

    //     $I->waitForElement('#warning_popup');
    //     $I->see('The New Password field must differ from the Old Password field');

    // }

    // private function changePasswordWrongOldPassword(AcceptanceTester $I)
    // {

    //     $I->fillField('old_password', 'wrongpassword');
    //     $I->fillField('new_password', 'newpassword');

    //     $I->click('#save_changes');

    //     $I->acceptPopup();

    //     $I->waitForElement('#danger_popup');
    //     $I->see('The Old Password is wrong');

    // }

    // private function changePasswordInvalidNewPassword(AcceptanceTester $I)
    // {

    //     $I->fillField('old_password', $this->new_data['password']);
    //     $I->fillField('new_password', 'pass');

    //     $I->click('#save_changes');

    //     $I->acceptPopup();

    //     $I->waitForElement('#warning_popup');
    //     $I->see('The New Password field must be at least 8 characters in length');

    // }

}
