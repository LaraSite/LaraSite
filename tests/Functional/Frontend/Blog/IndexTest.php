<?php

namespace Test\Functional\Frontend\Blog;

use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Entities\Article;
use App\Entities\Category;
use App\Entities\Tag;
use Symfony\Component\DomCrawler\Crawler;

class IndexTest extends \TestCase
{
    use DatabaseTransactions;

    public function testShowList()
    {
        $articles = factory(Article::class, 2)->create();

        $this->visit('blog')
            ->seeInElement('h1', 'Blog')
            ->see($articles[0]->title)
            ->see($articles[1]->title)
            ->see('1 / 1');     // paginator
    }

    public function testArticleFormat()
    {
        $category = factory(Category::class)->create();
        $tag = factory(Tag::class)->create();
        $article = factory(Article::class)->create([
            'body' => 'summary<!--more-->details',
            'category_id' => $category->id
        ]);
        $article->tags()->attach($tag);

        $this->visit('blog')
            ->see($article->title)
            ->see('foo')
            ->dontSee('details')
            ->see($article->published_at->format('Y-m-d'))
            ->see("Category: {$category->name} | Tag: {$tag->name}");
    }

    public function testStatus()
    {
        $published_article = factory(Article::class)->create();
        $draft_article = factory(Article::class)->create([
            'status' => 'Draft'
        ]);

        $this->visit('blog')
            ->see($published_article->title)
            ->dontSee($draft_article->title);
    }

    public function testOrder()
    {
        $article2 = factory(Article::class)->create([
            'title' => 'title-2',
            'published_at' => '2015-11-01 00:00'
        ]);
        $article1 = factory(Article::class)->create([
            'title' => 'title-1',
            'published_at' => '2015-11-02 00:00'
        ]);
        $article0 = factory(Article::class)->create([
            'title' => 'title-0',
            'published_at' => '2015-11-02 01:00'
        ]);

        $this->visit('blog');
        $nodeValues = $this->crawler->filter('article > h3')->each(function (Crawler $node, $i) {
            return trim($node->text());
        });
        $this->assertEquals($article0->title, $nodeValues[0]);
        $this->assertEquals($article1->title, $nodeValues[1]);
        $this->assertEquals($article2->title, $nodeValues[2]);
    }

    public function testPagination()
    {
        factory(Article::class, 16)->create();

        $this->visit('blog')
            ->see('1 / 2');     // paginator
    }

    public function testDoesNotExist()
    {
        $this->visit('blog')
            ->see('Article does not exist.');
    }
}
