<?php

namespace Test\Functional\Backend\Blog;

use Illuminate\Auth\GenericUser;

class MenuTest extends \TestCase
{
    public function setUp()
    {
        parent::setUp();

        $user = factory(GenericUser::class)->make();
        $this->actingAs($user);
    }

    public function testBlogSubMenu()
    {
        $urls = [
            '/admin/articles',
            '/admin/categories',
            '/admin/tags',
        ];

        foreach ($urls as $url) {
            $this->visit($url)
                ->seeInElement('#subMenu > .panel-heading', 'Blog')
                ->seeInElement('#subMenu > .list-group', 'Article')
                ->seeInElement('#subMenu > .list-group', 'Category')
                ->seeInElement('#subMenu > .list-group', 'Tag');
        }
    }

    public function testShowArticlePage()
    {
        $this->visit('/admin/articles');
        $this->click('Article')
            ->seePageIs('/admin/articles')
            ->seeInElement('h1', 'Article');
    }

    public function testShowCategoryPage()
    {
        $this->visit('/admin/articles');
        $this->click('Category')
            ->seePageIs('/admin/categories')
            ->seeInElement('h1', 'Category');
    }

    public function testShowTagPage()
    {
        $this->visit('/admin/articles');
        $this->click('Tag')
            ->seePageIs('/admin/tags')
            ->seeInElement('h1', 'Tag');
    }
}
