<?php

namespace Test\Functional\Backend;

use Illuminate\Auth\GenericUser;

class MenuTest extends \TestCase
{
    public function setUp()
    {
        parent::setUp();

        $user = factory(GenericUser::class)->make();
        $this->actingAs($user);

        $this->visit('/admin')
            ->see('Menu');
    }

    public function testShowBlog()
    {
        $this->click('Blog')
            ->seePageIs('/admin/articles')
            ->seeInElement('h1', 'Article');
    }

    public function testShowFilePage()
    {
        $this->click('File')
            ->seePageIs('/admin/upload_files')
            ->seeInElement('h1', 'File');
    }
}
