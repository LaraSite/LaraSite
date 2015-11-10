<?php

namespace Test\Functional\Backend\Blog\Tag;

use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Entities\Tag;
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
        $tags = factory(Tag::class, 2)->create();

        $this->visit('/admin/tags')
            ->see($tags[0]->title)
            ->see($tags[1]->title);

        $form = $this->getForm('Delete');
        $form['delete_items'][0]->tick();
        $form['delete_items'][1]->tick();
        $this->makeRequestUsingForm($form);

        $this->seePageIs('/admin/tags')
            ->see('The Tag has been deleted.')
            ->dontSee($tags[0]->name)
            ->dontSee($tags[1]->name);
    }
}
