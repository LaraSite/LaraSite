<?php

namespace Test\Functional\Backend\Blog\Article;

use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Entities\Article;
use App\Entities\Category;
use App\Entities\Tag;
use Illuminate\Auth\GenericUser;

class EditTest extends \TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $user = factory(GenericUser::class)->make();
        $this->actingAs($user);
    }

    public function testEdit()
    {
        $categories = factory(Category::class, 2)->create();
        $tags = factory(Tag::class, 2)->create();
        $article = factory(Article::class)->create([
            'category_id' => $categories[0]->id,
            'status' => 'Draft'
        ]);
        $article->tags()->attach($tags[0]->id);

        $this->visit('/admin/articles')
            ->click($article->title)

            ->seePageIs(route('admin.articles.edit', ['id' => $article->id]))
            ->seeInElement('h1', 'Edit Article')
            ->type('SomeTitle', 'title')
            ->type('SomeBody', 'body')
            ->select($categories[1]->id, 'category_id')
            ->select($tags[1]->id, 'tag_list')
            ->select('Published', 'status')
            ->type('2015-11-01 00:00', 'published_at')
            ->press('Update')

            ->seePageIs(route('admin.articles.edit', ['id' => $article->id]))
            ->seeInElement('h1', 'Edit Article')
            ->see('The Article has been updated.')
            ->see('SomeTitle')
            ->see('SomeBody')
            ->seeIsSelected('#category_id', $categories[1]->id)
            ->seeIsSelected('#tag_list', $tags[1]->id)
            ->seeIsSelected('#status', 'Published')
            ->see('2015-11-01 00:00');
    }

    public function testCreateValidationFail()
    {
        $article = factory(Article::class)->create();

        $this->visit('/admin/articles')
            ->click($article->title)

            ->seePageIs(route('admin.articles.edit', ['id' => $article->id]))
            ->seeInElement('h1', 'Edit Article')
            ->type('', 'title')
            ->press('Update')

            ->seePageIs(route('admin.articles.edit', ['id' => $article->id]))
            ->see('The Title field is required.');
    }
}
