<?php

namespace Test\Functional\Frontend\Blog;

use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Entities\Article;
use App\Entities\Category;
use App\Entities\Tag;
use Symfony\Component\DomCrawler\Crawler;

class ShowTest extends \TestCase
{
    use DatabaseTransactions;

    public function testShowArticle()
    {
        $category = factory(Category::class)->create();
        $tag = factory(Tag::class)->create();
        $article = factory(Article::class)->create([
            'body' => 'foo<!--more-->bar',
            'category_id' => $category->id
        ]);
        $article->tags()->attach($tag);

        $this->visit('blog')
            ->see('Blog')
            ->click($article->title)

            ->seePageIs("/blog/{$article->id}")
            ->see('Blog')
            ->see($article->title)
            ->see($article->body)
            ->see($article->published_at->format('Y-m-d'))
            ->see("Category: {$category->name} | Tag: {$tag->name}");
    }
}
