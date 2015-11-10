<?php

namespace Test\Functional\Backend\Blog\Article;

use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Entities\Article;
use App\Entities\Category;
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
        $articles = factory(Article::class, 2)->create();

        $this->visit('/admin/articles')
            ->see($articles[0]->title)
            ->see($articles[1]->title);

        $form = $this->getForm('Delete');
        $form['delete_items'][0]->tick();
        $form['delete_items'][1]->tick();
        $this->makeRequestUsingForm($form);

        $this->seePageIs('/admin/articles')
            ->see('The Article has been deleted.')
            ->dontSee($articles[0]->title)
            ->dontSee($articles[1]->title);
    }
}
