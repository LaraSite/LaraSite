<?php

namespace Test\Functional\Backend\Blog\Tag;

use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Entities\Article;
use App\Entities\Tag;
use Illuminate\Auth\GenericUser;

class IndexTest extends \TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $user = factory(GenericUser::class)->make();

        $this->actingAs($user);
    }

    public function testShowList()
    {
        $tags = factory(Tag::class, 2)->create();

        $this->visit('/admin/tags')
            ->seeInElement('h1', 'Tag')
            ->see($tags[0]->name)
            ->see($tags[1]->name)
            ->see('1 / 1');     // paginator
    }

    public function testTagFormat()
    {
        $tag = factory(Tag::class)->create();
        $articles = factory(Article::class, 2)->create()
            ->each(function ($article) use ($tag) {
                $article->tags()->attach($tag->id);
            });

        $this->visit('/admin/tags')
            ->see($tag->name)
            ->seeInElement('td > span.badge', '2');
    }

    public function testPagination()
    {
        factory(Tag::class, 16)->create();

        $this->visit('/admin/tags')
            ->see('1 / 2');     // paginator
    }

    public function testDoesNotExist()
    {
        $this->visit('/admin/tags')
            ->see('Tag does not exist.');
    }
}
