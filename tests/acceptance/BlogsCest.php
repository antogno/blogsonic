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

        $I->tryToAcceptCookiePopup($I);

        $I->register($I, $this->data);
        $I->login($I, ['username' => $this->data['username'], 'password' => $this->data['password']]);
        
        $I->amOnPage('/en');

    }

    public function newBlog(AcceptanceTester $I)
    {

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

        $I->createNewBlog($I, $this->blog);

        $I->click('Blogs');
        $I->click('All');

        $I->waitForElement('#card');
        $I->see($this->blog['title']);
        $I->click('View');

        $I->waitForElement('#card');
        $I->see($this->blog['title']);
        $I->see($this->data['username']);
        $I->see($this->blog['body']);

        $I->logout($I);

        $I->click('Blogs');
        $I->dontSee('My Blogs');

        $I->login($I, ['username' => $this->data['username'], 'password' => $this->data['password']]);

        $I->click('Blogs');
        $I->click('My Blogs');

        $I->waitForElement('#card');
        $I->see($this->blog['title']);

    }

    public function editBlog(AcceptanceTester $I)
    {

        $I->createNewBlog($I, $this->blog);

        $I->click('Blogs');
        $I->click('My Blogs');
        $I->click('View');

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

    public function deleteBlog(AcceptanceTester $I)
    {

        $I->createNewBlog($I, $this->blog);

        $I->click('Blogs');
        $I->click('My Blogs');
        $I->click('View');

        $I->click('#delete');

        $I->acceptPopup();

        $I->waitForElement('#page_body');
        $I->see('The are no Blogs to show');

    }

    public function searchFilters(AcceptanceTester $I)
    {

        $I->createNewBlog($I, ['title' => 'Title 01', 'body' => 'Body 01']);
        $I->createNewBlog($I, ['title' => 'Title 02', 'body' => 'Body 02']);
        $I->createNewBlog($I, ['title' => 'Title 03', 'body' => 'Body 03']);
        $I->createNewBlog($I, ['title' => 'Title 04', 'body' => 'Body 04']);
        $I->createNewBlog($I, ['title' => 'Title 05', 'body' => 'Body 05']);
        $I->createNewBlog($I, ['title' => 'Title 06', 'body' => 'Body 06']);
        $I->createNewBlog($I, ['title' => 'Title 07', 'body' => 'Body 07']);
        $I->createNewBlog($I, ['title' => 'Title 08', 'body' => 'Body 08']);
        $I->createNewBlog($I, ['title' => 'Title 09', 'body' => 'Body 09']);
        $I->createNewBlog($I, ['title' => 'Title 10', 'body' => 'Body 10']);
        $I->createNewBlog($I, ['title' => 'Title 11', 'body' => 'Body 11']);
        $I->createNewBlog($I, ['title' => 'Title 12', 'body' => 'Body 12']);
        $I->createNewBlog($I, ['title' => 'Title 13', 'body' => 'Body 13']);
        $I->createNewBlog($I, ['title' => 'Title 14', 'body' => 'Body 14']);
        $I->createNewBlog($I, ['title' => 'Title 15', 'body' => 'Body 15']);

        $I->click('Blogs');
        $I->click('My Blogs');
        $I->waitForElement('#page_body');
        $I->see('Title 15');
        $I->see('Title 14');
        $I->see('Title 13');
        $I->see('Title 12');
        $I->see('Title 11');
        $I->dontSee('Title 10');

        $I->selectOption('#change_order', 'asc');
        $I->click('#change_options');
        $I->waitForElement('#page_body');
        $I->see('Title 01');
        $I->see('Title 02');
        $I->see('Title 03');
        $I->see('Title 04');
        $I->see('Title 05');
        $I->dontSee('Title 06');

        $I->selectOption('#change_limit', '10');
        $I->click('#change_options');
        $I->waitForElement('#page_body');
        $I->see('Title 01');
        $I->see('Title 02');
        $I->see('Title 03');
        $I->see('Title 04');
        $I->see('Title 05');
        $I->see('Title 06');
        $I->see('Title 07');
        $I->see('Title 08');
        $I->see('Title 09');
        $I->see('Title 10');
        $I->dontSee('Title 11');

        $I->executeJS("$('#date_max').val('1970-01-01');");
        $I->click('#change_options');
        $I->waitForElement('#page_body');
        $I->see('You haven\'t posted any Blogs yet');

        $I->executeJS("$('#date_min').val('" . date('Y-m-d', strtotime('yesterday')) . "');");
        $I->executeJS("$('#date_max').val('" . date('Y-m-d', time()) . "');");
        $I->click('#change_options');
        $I->waitForElement('#page_body');
        $I->see('Title 01');
        $I->see('Title 02');
        $I->see('Title 03');
        $I->see('Title 04');
        $I->see('Title 05');
        $I->see('Title 06');
        $I->see('Title 07');
        $I->see('Title 08');
        $I->see('Title 09');
        $I->see('Title 10');
        $I->dontSee('Title 11');

    }

}
