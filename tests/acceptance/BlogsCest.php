<?php

class BlogsCest
{

    public $data = [
        'name' => 'Blogs',
        'surname' => 'Test',
        'gender' => 'm',
        'username' => 'blogstest',
        'password' => 'password',
        'email' => 'blogs@test.com',
        'phone' => '0987654321',
        'language' => 'en',
    ];

    public $blog = [
        'title' => 'Incredible',
        'body' => 'Magnificent'
    ];

    public $new_blog = [
        'title' => 'Impressive',
        'body' => 'Splendid'
    ];

    public function _before(AcceptanceTester $I)
    {

        $I->amOnPage('/en');

    }

    public function newBlog(AcceptanceTester $I)
    {

        $I->register($I, $this->data);
        $I->login($I, ['username' => $this->data['username'], 'password' => $this->data['password']]);

        $I->click('Blogs');
        $I->click('New Blog');

        $I->fillField('title', $this->blog['title']);
        $I->fillField('body', $this->blog['body']);

        $I->click('#post');

        $I->waitForElement('#card');
        $I->see($this->blog['title']);

    }

    public function viewBlog(AcceptanceTester $I)
    {

        $I->click('Blogs');
        $I->click('All');

        $I->waitForElement('#card');
        $I->see($this->blog['title']);
        $I->click('View');

        $I->waitForElement('#card');
        $I->see($this->blog['title']);
        $I->see($this->data['username']);
        $I->see($this->blog['body']);

        $I->click('Blogs');
        $I->dontSee('My Blogs');

        $I->login($I, ['username' => $this->data['username'], 'password' => $this->data['password']]);

        $I->click('Blogs');
        $I->click('My Blogs');

        $I->waitForElement('#card');
        $I->see($this->blog['title']);
        $I->click('View');

        $this->editBlog($I);
        $this->deleteBlog($I);

        $I->deleteProfile($I, []);

    }

    private function editBlog(AcceptanceTester $I)
    {

        $I->click('#edit');

        $I->seeInField('title', $this->blog['title']);
        $I->seeInField('body', $this->blog['body']);

        $I->fillField('title', $this->new_blog['title']);
        $I->fillField('body', $this->new_blog['body']);

        $I->click('#post');

        $I->acceptPopup();

        $I->waitForElement('#card');
        $I->see($this->new_blog['title']);
        $I->click('View');

        $I->waitForElement('#card');
        $I->see($this->new_blog['title']);
        $I->see($this->data['username']);
        $I->see($this->new_blog['body']);

    }

    private function deleteBlog(AcceptanceTester $I)
    {

        $I->click('#delete');

        $I->acceptPopup();

        $I->see('The are no Blogs to show');

    }

}
