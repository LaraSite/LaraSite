<?php

namespace Test\Functional\Backend\Blog\Category;

use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Entities\Category;
use Illuminate\Auth\GenericUser;

class DeleteTest extends \TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $user = factory(GenericUser::class)->make();
        $this->actingAs($user);
    }

    public function testDelete()
    {
        $categories = factory(Category::class, 2)->create();

        $this->visit('/admin/categories')
            ->see($categories[0]->title)
            ->see($categories[1]->title);

        $form = $this->getForm('Delete');
        $form['delete_items'][0]->tick();
        $form['delete_items'][1]->tick();
        $this->makeRequestUsingForm($form);

        $this->seePageIs('/admin/categories')
            ->see('The Category has been deleted.')
            ->dontSee($categories[0]->name)
            ->dontSee($categories[1]->name);
    }
}
