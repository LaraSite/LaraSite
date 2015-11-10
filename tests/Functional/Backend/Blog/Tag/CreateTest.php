<?php

namespace Test\Functional\Backend\Blog\Tag;

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
        $this->visit('/admin/tags')
            ->type('SomeTag', 'name')
            ->press('Add')

            ->seePageIs('/admin/tags')
            ->see('The Tag has been saved.')
            ->see('SomeTag');
    }

    public function testCreateValidationFail()
    {
        $this->visit('/admin/tags')
            ->type('', 'name')
            ->press('Add')

            ->seePageIs('/admin/tags')
            ->see('The Name field is required.');
    }
}
