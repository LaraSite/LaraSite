<?php

namespace Test\Functional\Backend\Blog\Category;

use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Auth\GenericUser;

class CreateTest extends \TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $user = factory(GenericUser::class)->make();
        $this->actingAs($user);
    }

    public function testCreate()
    {
        $this->visit('/admin/categories')
            ->type('SomeCategory', 'name')
            ->press('Add')

            ->seePageIs('/admin/categories')
            ->see('The Category has been saved.')
            ->see('SomeCategory');
    }

    public function testCreateValidationFail()
    {
        $this->visit('/admin/categories')
            ->type('', 'name')
            ->press('Add')

            ->seePageIs('/admin/categories')
            ->see('The Name field is required.');
    }
}
