<?php

namespace Test\Functional\Backend\Blog\Article;

use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Entities\Article;
use App\Entities\Category;
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
        $articles = factory(Article::class, 2)->create();

        $this->visit('/admin/articles')
            ->seeInElement('h1', 'Article')
            ->see($articles[0]->title)
            ->see($articles[1]->title)
            ->see('1 / 1');     // paginator
    }

    public function testArticleFormat()
    {
        $category = factory(Category::class)->create();
        $article = factory(Article::class)->create([
            'category_id' => $category->id
        ]);

        $this->visit('/admin/articles')
            ->see($article->title)
            ->see($article->status)
            ->see($category->name)
            ->see($article->published_at->format('Y-m-d H:i'));
    }

    public function testPagination()
    {
        factory(Article::class, 16)->create();

        $this->visit('/admin/articles')
            ->see('1 / 2');     // paginator
    }

    public function testDoesNotExist()
    {
        $this->visit('/admin/articles')
            ->see('Article does not exist.');
    }
}
