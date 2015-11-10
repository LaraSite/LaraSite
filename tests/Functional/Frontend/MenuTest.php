<?php

namespace Test\Functional\Frontend;

use Illuminate\Foundation\Testing\HttpException;
use Illuminate\Auth\GenericUser;

class MenuTest extends \TestCase
{
    public function testShowRootPage()
    {
        $this->visit('/')
            ->see('LaraSite');
    }

    public function testShowBrandPage()
    {
        $this->visit('/')
            ->click('LaraSite')
            ->seePageIs('/');
    }

    public function testShowHomePage()
    {
        $this->visit('/')
            ->click('Home')
            ->seePageIs('/');
    }

    public function testShowBlogPage()
    {
        $this->visit('/')
            ->click('Blog')
            ->seePageIs('/blog')
            ->see('Blog');
    }

    public function testShowPagePage()
    {
        $this->visit('/')
            ->click('Page')
            ->seePageIs('/page')
            ->see('Page');
    }

    public function testShowRightSidebarPage()
    {
        $this->visit('/')
            ->click('Right Sidebar')
            ->seePageIs('/right_sidebar')
            ->see('Right Sidebar');
    }

    public function testShowLeftSidebarPage()
    {
        $this->visit('/')
            ->click('Left Sidebar')
            ->seePageIs('/left_sidebar')
            ->see('Left Sidebar');
    }

    public function testShowContactPage()
    {
        $this->visit('/')
            ->click('Contact')
            ->seePageIs('/contact')
            ->see('Contact');
    }

    public function testUnauthorizedAdminArea()
    {
        try {
            $this->visit('/')
                ->click('Admin');
            $this->fail("Did not throw HttpException!");
        } catch (HttpException $e) {
            $this->assertEquals(401, $this->response->getStatusCode());
        }
    }

    public function testAuthorizedAdminArea()
    {
        $user = factory(GenericUser::class)->make();

        $this->actingAs($user)
            ->visit('/')
            ->click('Admin')
            ->seePageIs('/admin/articles')
            ->see('Article');
    }
}
