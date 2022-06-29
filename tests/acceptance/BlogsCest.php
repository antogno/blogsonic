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

        $I->fillField('blog_title', $this->blog['title']);
        $I->fillField('blog_body', $this->blog['body']);

        $I->click('#post');

        $I->waitPageLoad($I);
        $I->see($this->blog['title']);
    }

    public function viewBlog(AcceptanceTester $I)
    {
        $I->createNewBlog($I, $this->blog);

        $I->click('Blogs');
        $I->click('All Blogs');

        $I->waitPageLoad($I);
        $I->see($this->blog['title']);
        $I->click('View');

        $I->waitPageLoad($I);
        $I->see($this->blog['title']);
        $I->see($this->data['username']);
        $I->see($this->blog['body']);

        $I->logout($I);

        $I->click('Blogs');
        $I->dontSee('My Blogs');

        $I->login($I, ['username' => $this->data['username'], 'password' => $this->data['password']]);

        $I->click('Blogs');
        $I->click('My Blogs');

        $I->waitPageLoad($I);
        $I->see($this->blog['title']);
    }

    public function editBlog(AcceptanceTester $I)
    {
        $I->createNewBlog($I, $this->blog);

        $I->click('Blogs');
        $I->click('My Blogs');
        $I->click('View');

        $I->click('#edit');

        $I->seeInField('blog_title', $this->blog['title']);
        $I->seeInField('blog_body', $this->blog['body']);

        $I->fillField('blog_title', $this->new_blog['title']);
        $I->fillField('blog_body', $this->new_blog['body']);

        $I->click('#post');

        $I->acceptPopup();

        $I->waitPageLoad($I);
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

        $I->waitPageLoad($I);
        $I->see('You haven\'t posted any Blogs yet');
    }

    public function searchFilters(AcceptanceTester $I)
    {
        $I->createNewBlog($I, ['title' => 'Title 01', 'body' => 'Body 01'], 1);
        $I->createNewBlog($I, ['title' => 'Title 02', 'body' => 'Body 02'], 1);
        $I->createNewBlog($I, ['title' => 'Title 03', 'body' => 'Body 03'], 1);
        $I->createNewBlog($I, ['title' => 'Title 04', 'body' => 'Body 04'], 1);
        $I->createNewBlog($I, ['title' => 'Title 05', 'body' => 'Body 05'], 1);
        $I->createNewBlog($I, ['title' => 'Title 06', 'body' => 'Body 06'], 1);

        $I->click('Blogs');
        $I->click('My Blogs');
        $I->waitPageLoad($I);
        $I->see('Title 06');
        $I->see('Title 05');
        $I->see('Title 04');
        $I->see('Title 03');
        $I->see('Title 02');
        $I->dontSee('Title 01');

        $I->selectOption('#order', 'asc');
        $I->click('#change_options');
        $I->waitPageLoad($I);
        $I->see('Title 01');
        $I->see('Title 02');
        $I->see('Title 03');
        $I->see('Title 04');
        $I->see('Title 05');
        $I->dontSee('Title 06');

        $I->fillField('#limit', '2');
        $I->click('#change_options');
        $I->waitPageLoad($I);
        $I->see('Title 01');
        $I->see('Title 02');

        $I->executeJS("$('#date_max').val('1970-01-01');");
        $I->click('#change_options');
        $I->waitPageLoad($I);
        $I->see('You haven\'t posted any Blogs yet');

        $I->executeJS("$('#date_min').val('" . date('Y-m-d', strtotime('yesterday')) . "');");
        $I->executeJS("$('#date_max').val('" . date('Y-m-d', strtotime('tomorrow')) . "');");
        $I->fillField('#limit', '6');
        $I->click('#change_options');
        $I->waitPageLoad($I);
        $I->see('Title 01');
        $I->see('Title 02');
        $I->see('Title 03');
        $I->see('Title 04');
        $I->see('Title 05');
        $I->see('Title 06');
    }
}