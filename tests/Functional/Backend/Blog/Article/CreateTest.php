<?php

namespace Test\Functional\Backend\Blog\Article;

use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Entities\Category;
use App\Entities\Tag;
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
        $categories = factory(Category::class, 2)->create();
        $tags = factory(Tag::class, 2)->create();

        $this->visit('/admin/articles')
            ->click('New')

            ->seePageIs('/admin/articles/create')
            ->seeInElement('h1', 'New Article')
            ->type('SomeTitle', 'title')
            ->type('Body', 'body')
            ->select($categories[0]->id, 'category_id')
            ->select($tags[0]->id, 'tag_list')
            ->select('Published', 'status')
            ->type('2015-11-01 00:00', 'published_at')
            ->press('Add')

            ->seePageIs('/admin/articles')
            ->seeInElement('h1', 'Article')
            ->see('The Article has been saved.')
            ->see('SomeTitle');
    }

    public function testCreateValidationFail()
    {
        $this->visit('/admin/articles')
            ->click('New')

            ->seePageIs('/admin/articles/create')
            ->seeInElement('h1', 'New Article')
            ->press('Add')

            ->seePageIs('/admin/articles/create')
            ->see('The Title field is required.')
            ->see('The Body field is required.');
    }
}
