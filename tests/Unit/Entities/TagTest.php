<?php

namespace Test\Unit\Entities;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\Article;
use App\Entities\Tag;

class TagTest extends \TestCase
{
    use DatabaseTransactions;

    public function testArticles()
    {
        /** @var Tag $category */
        $tag = factory(Tag::class)->create();
        /** @var Article $articles */
        $articles = factory(Article::class, 3)->create();
        foreach ($articles as $article) {
            $article->tags()->attach($tag->id);
        }

        $this->assertEquals(3, $tag->articles()->count());
    }
}
